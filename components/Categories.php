<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use OFFLINE\SnipcartShop\Models\Category;
use OFFLINE\SnipcartShop\Models\GeneralSettings;

class Categories extends ComponentBase
{
    use SetsVars;

    /**
     * List only categories that are a child of this
     * category.
     * @var int
     */
    public $parent;
    /**
     * Categories that will be displayed
     * @var
     */
    public $categories;
    /**
     * Categories that will be displayed
     */
    public $categoryPage;

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.categories.details.name',
            'description' => 'offline.snipcartshop::lang.components.categories.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefix = 'offline.snipcartshop::lang.components.categories.properties.';

        return [
            'parent'       => [
                'title'       => $langPrefix . 'parent.title',
                'description' => $langPrefix . 'parent.description',
                'type'        => 'dropdown',
            ],
            'categorySlug' => [
                'title'       => $langPrefix . 'categorySlug.title',
                'description' => $langPrefix . 'categorySlug.description',
                'type'        => 'string',
                'default'     => '{{ :slug }}',
            ],
            'categoryPage' => [
                'title'       => $langPrefix . 'categoryPage.title',
                'description' => $langPrefix . 'categoryPage.description',
                'type'        => 'dropdown',
            ],
        ];
    }

    public function getParentOptions()
    {
        $categories = Category::listsNested('name', 'id');
        // If no array is returned there are no categories
        // created yet. So let's use an empty array for now.
        if ( ! is_array($categories)) {
            $categories = [];
        }

        return [null => '(' . trans('offline.snipcartshop::lang.components.categories.no_parent') . ')']
            + ['{slug}' => '(' . trans('offline.snipcartshop::lang.components.categories.by_slug') . ')']
            + $categories;
    }

    public function onRun()
    {
        $this->setVar('parent', $this->property('parent'));
        $this->setVar('categories', $this->getCategories());
        $this->setVar('categoryPage', $this->getCategoryPage());
    }

    public function getCategoryPageOptions()
    {
        return [null => '(' . trans('offline.snipcartshop::lang.plugin.common.use_backend_defaults') . ')']
            + Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    private function getCategoryPage()
    {
        if ($this->property('categoryPage')) {
            return $this->property('categoryPage');
        }

        return GeneralSettings::get('category_page');
    }

    protected function getCategories()
    {
        if ($this->parent === '{slug}') {
            // Get the last slug part and use this as category slug
            $slugs = explode('/', $this->property('categorySlug'));
            $slug  = end($slugs);

            // Find the id of the current category and set it as parent
            $category = new Category();
            $category = $category->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
                ? $category->transWhere('slug', $slug)
                : $category->where('slug', $slug);

            $this->parent = $category->first(['id'])->id;
        }

        // Return children or all categories, based on the current parent setting
        return $this->parent ? Category::find($this->parent)->getAllChildren() : Category::getNested();
    }

}