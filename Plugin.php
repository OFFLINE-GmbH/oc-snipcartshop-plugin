<?php namespace OFFLINE\SnipcartShop;

use Event;
use OFFLINE\SnipcartShop\Models\Category;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'OFFLINE\SnipcartShop\Components\Products' => 'products',
            'OFFLINE\SnipcartShop\Components\Product'  => 'product',
            'OFFLINE\SnipcartShop\Components\SnipcartDependencies'  => 'snipcartDependencies',
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'offline.snipcartshop::lang.plugin.settings.label',
                'description' => 'offline.snipcartshop::lang.plugin.settings.description',
                'category'    => 'offline.snipcartshop::lang.plugin.settings.category',
                'icon'        => 'icon-shopping-cart',
                'class'       => 'OFFLINE\SnipcartShop\Models\Settings',
                'order'       => 0,
                'keywords'    => 'shop store snipcart',
            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'OFFLINE\SnipcartShop\FormWidgets\VariantSelector' => 'variantselector',
        ];
    }

    public function boot()
    {
        Event::listen('pages.menuitem.listTypes', function () {
            return [
                'all-snipcartshop-categories' => trans('offline.snipcartshop::lang.plugin.menu_items.all_categories'),
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function ($type) {
            if ($type == 'all-snipcartshop-categories') {
                return Category::getMenuTypeInfo($type);
            }
        });

        Event::listen('pages.menuitem.resolveItem', function ($type, $item, $url, $theme) {
            if ($type == 'all-snipcartshop-categories') {
                return Category::resolveMenuItem($item, $url, $theme);
            }
        });
    }
}
