{
  pkgs ? import <nixpkgs> { }
  ,phpVersion ? "php82"
}:

let
  php = pkgs.${phpVersion}.buildEnv {
    extensions = { enabled, all }: enabled ++ (with all; [
      xdebug
    ]);

    extraConfig = ''
      xdebug.mode = debug
      memory_limit = 4G
    '';
  };
  inherit(pkgs."${phpVersion}Packages") composer;

  projectInstall = pkgs.writeShellApplication {
    name = "project-install";
    runtimeInputs = [
      php
      composer
    ];
    text = ''
      composer update --prefer-dist --no-progress
    '';
  };

  projectCgl = pkgs.writeShellApplication {
    name = "project-cgl";

    runtimeInputs = [
      php
    ];

    text = ''
      ./vendor/bin/php-cs-fixer fix --config=Build/.php-cs-fixer.dist.php -v --dry-run --diff
    '';
  };

  projectCglFix = pkgs.writeShellApplication {
    name = "project-cgl-fix";

    runtimeInputs = [
      php
    ];

    text = ''
      ./vendor/bin/php-cs-fixer fix --config=Build/.php-cs-fixer.dist.php
    '';
  };

  projectLintPhp = pkgs.writeShellApplication {
    name = "project-lint-php";

    runtimeInputs = [
      php
    ];

    text = ''
      find ./*.php Classes Configuration Tests -name '*.php' -print0 | xargs -0 -n 1 -P 4 php -l
    '';
  };

  projectLintTypoScript = pkgs.writeShellApplication {
    name = "project-lint-typoscript";

    runtimeInputs = [
      php
    ];

    text = ''
      ./vendor/bin/typoscript-lint -c Build/typoscriptlint.yaml Configuration
    '';
  };

  projectPhpstan = pkgs.writeShellApplication {
    name = "project-phpstan";

    runtimeInputs = [
      php
    ];

    text = ''
      ./vendor/bin/phpstan analyse -c Build/phpstan.neon --memory-limit 256M
    '';
  };

  projectTestUnit = pkgs.writeShellApplication {
    name = "project-test-unit";
    runtimeInputs = [
      php
      projectInstall
    ];
    text = ''
      project-install
      vendor/bin/phpunit -c Build/UnitTests.xml
    '';
  };

  projectTestFunctional = pkgs.writeShellApplication {
    name = "project-test-functional";
    runtimeInputs = [
      php
      projectInstall
    ];
    text = ''
      project-install
      vendor/bin/phpunit -c Build/FunctionalTests.xml
    '';
  };

  projectTestAcceptance = pkgs.writeShellApplication {
    name = "project-test-acceptance";
    runtimeInputs = [
      projectInstall
      pkgs.sqlite
      pkgs.firefox
      pkgs.geckodriver
      pkgs.procps
      php
    ];
    text = ''
      project-install

      mkdir -p "$PROJECT_ROOT/.build/web/typo3temp/var/tests/acceptance"
      mkdir -p "$PROJECT_ROOT/.build/web/typo3temp/var/tests/acceptance-logs"
      mkdir -p "$PROJECT_ROOT/.build/web/typo3temp/var/tests/acceptance-reports"
      mkdir -p "$PROJECT_ROOT/.build/web/typo3temp/var/tests/acceptance-sqlite-dbs"

      export INSTANCE_PATH="$PROJECT_ROOT/.build/web/typo3temp/var/tests/acceptance"

      ./vendor/bin/codecept run

      pgrep -f "php -S" | xargs -r kill
      pgrep -f "geckodriver" | xargs -r kill
    '';
  };

in pkgs.mkShell {
  name = "TYPO3 Extension cart-books";
  buildInputs = [
    php
    composer
    projectInstall
    projectPhpstan
    projectCgl
    projectCglFix
    projectLintPhp
    projectLintTypoScript
    projectTestUnit
    projectTestFunctional
    projectTestAcceptance
  ];
  packages = [ pkgs.gnumake pkgs.busybox ];

  shellHook = ''
    export TMPDIR=$HOME/.cache/development/cart_books

    export PROJECT_ROOT="$(pwd)"

    export typo3DatabaseDriver=pdo_sqlite
  '';
}
