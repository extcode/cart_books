<?php
declare(strict_types=1);
namespace Extcode\CartBooks\Domain\Repository;

/*
 * This file is part of the package extcode/cart-books.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\Domain\Model\Category;

class CategoryRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
{
    public function findAllAsRecursiveTreeArray(Category $selectedCategory = null): array
    {
        $categoriesArray = $this->findAllAsArray($selectedCategory);
        $categoriesTree = $this->buildSubcategories($categoriesArray, null);

        return $categoriesTree;
    }

    public function findAllAsArray(Category $selectedCategory = null): array
    {
        $localCategories = $this->findAll();
        $categories = [];
        // Transform categories to array
        foreach ($localCategories as $localCategory) {
            $newCategory = [
                'uid' => $localCategory->getUid(),
                'title' => $localCategory->getTitle(),
                'parent' => ($localCategory->getParent() ? $localCategory->getParent()->getUid() : null),
                'subcategories' => null,
                'isSelected' => ($selectedCategory == $localCategory ? true : false),
            ];
            $categories[] = $newCategory;
        }

        return $categories;
    }

    public function findSubcategoriesRecursiveAsArray(Category $parentCategory): array
    {
        $categories = [];
        $localCategories = $this->findAllAsArray();
        foreach ($localCategories as $category) {
            if (
                ($parentCategory && $category['uid'] === $parentCategory->getUid()) ||
                !$parentCategory
            ) {
                $this->getSubcategoriesIds(
                    $localCategories,
                    $category,
                    $categories
                );
            }
        }

        return $categories;
    }

    protected function getSubcategoriesIds(
        array $categoriesArray,
        array $parentCategory,
        array &$subcategoriesArray
    ): void {
        $subcategoriesArray[] = $parentCategory['uid'];
        foreach ($categoriesArray as $category) {
            if ($category['parent'] === $parentCategory['uid']) {
                $this->getSubcategoriesIds(
                    $categoriesArray,
                    $category,
                    $subcategoriesArray
                );
            }
        }
    }

    protected function buildSubcategories(array $categoriesArray, array $parentCategory): array
    {
        $categories = null;
        foreach ($categoriesArray as $category) {
            if ($category['parent'] == $parentCategory['uid']) {
                $newCategory = $category;
                $newCategory['subcategories'] =
                    $this->buildSubcategories($categoriesArray, $category);
                $categories[] = $newCategory;
            }
        }

        return $categories;
    }
}
