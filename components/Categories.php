<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;
use OFFLINE\SnipcartShop\Models\Category;
use OFFLINE\SnipcartShop\Models\GeneralSettings;
use Cms\Classes\Page;

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
            'parent' => [
                'title'       => $langPrefix . 'parent.title',
                'description' => $langPrefix . 'parent.description',
                'type'        => 'dropdown',
            ],
            'categoryPage'       => [
                'title'       => $langPrefix . 'categoryPage.title',
                'description' => $langPrefix . 'categoryPage.description',
                'type'        => 'dropdown'
            ],
        ];
    }

    public function getParentOptions()
    {
        return [null => '(' . trans('offline.snipcartshop::lang.components.categories.no_parent') . ')']
            + Category::listsNested('name', 'id');
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
        return $this->parent ? Category::find($this->parent)->getAllChildren() : Category::getNested();
    }

}