<?php namespace OFFLINE\SnipcartShop\Models;

use Cms\Classes\Controller;
use InvalidArgumentException;
use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;

    public $timestamps = true;
    public $table = 'offline_snipcartshop_categories';
    public $translatable = ['name', ['slug', 'index' => true], 'meta_description', 'meta_title'];
    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];

    public $rules = [
        'name' => 'required',
        'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:offline_snipcartshop_categories'],
    ];

    public $belongsToMany = [
        'products' => [
            'OFFLINE\SnipcartShop\Models\Product',
            'table'    => 'offline_snipcartshop_category_product',
            'key'      => 'category_id',
            'otherKey' => 'product_id',
        ],
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    /**
     * Returns an array with possible parent categories.
     *
     * If we are in create mode (no id) all categories are returned.
     * If an id is set, we need to exclude the current node itself to
     * prevent an infinite parent-child relationship.
     *
     * @return array
     */
    public function getParentOptions()
    {
        $options = [
            // null key for "no parent"
            null => '(' . trans('offline.snipcartshop::lang.plugin.category.no_parent') . ')',
        ];

        // In edit mode, exclude the node itself.
        $items = $this->id ? Category::withoutSelf()->get() : Category::getAll();
        $items->each(function ($item) use (&$options) {
            return $options[$item->id] = sprintf('%s %s', str_repeat('--', $item->getLevel()), $item->name);
        });

        return $options;
    }

    public static function getMenuTypeInfo($type)
    {
        $result = [];
        if ($type == 'all-snipcartshop-categories') {
            $result = [
                'dynamicItems' => true,
            ];
        }

        return $result;
    }

    /**
     * @param $item
     * @param $url
     * @param $theme
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function resolveMenuItem($item, $url, $theme)
    {
        $structure = [];
        $category  = new Category();

        $pageSlug = GeneralSettings::get('category_page_slug', 'slug');
        if ($pageSlug === '') {
            $pageSlug = 'slug';
        }

        if ( ! $pageUrl = GeneralSettings::get('category_page')) {
            throw new InvalidArgumentException(
                'SnipcartShop: Please select a category page via the backend settings.'
            );
        }

        $iterator = function ($items, $baseUrl = '') use (&$iterator, &$structure, $pageUrl, $pageSlug, $url) {
            $branch = [];

            $controller = new Controller();
            foreach ($items as $item) {
                $entryUrl               = $controller->pageUrl($pageUrl, [$pageSlug => $item->slug]);
                $branchItem             = [];
                $branchItem['url']      = $entryUrl;
                $branchItem['isActive'] = $entryUrl === $url;
                $branchItem['title']    = $item->name;

                if ($item->children) {
                    $branchItem['items'] = $iterator($item->children, $item->slug);
                }

                $branch[] = $branchItem;
            }

            return $branch;
        };

        $structure['items'] = $iterator($category->getEagerRoot());

        return $structure;
    }

    public static function allowedSortingOptions()
    {
        $name    = trans('offline.snipcartshop::lang.plugin.product.name');
        $created = trans('offline.snipcartshop::lang.plugin.common.created_at');

        return [
            'name asc'        => "${name}, A->Z",
            'name desc'       => "${name}, Z->A",
            'created_at asc'  => "${created}, A->Z",
            'created_at desc' => "${created}, Z->A",
        ];
    }
}