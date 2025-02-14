.. include:: ../../Includes.rst.txt

====================================================
Breaking: #48 - Remove Switchable Controller Actions
====================================================

See :issue:`48`

Description
===========

Switchable controller actions have been marked as deprecated in TYPO3 Core and will be removed in one of the next major
versions of TYPO3, probably version 11.0 or 12.0.

See also:
`Deprecation: #89463 - Switchable Controller Actions <https://docs.typo3.org/c/typo3/cms-core/master/en-us/Changelog/10.3/Deprecation-89463-SwitchableControllerActions.html>`_

There is no need to retain the switchable controller actions, so they have already been removed from the extension.

Impact
======

Plugins that are using switchable controller actions need to be split into multiple different plugins.

Migration
=========

Unfortunately, an automatic migration is not possible. As switchable controller actions allowed to override the whole
configuration of allowed controllers and actions, the only way to migrate is to create dedicated plugins for each former
switchable controller actions configuration entry.