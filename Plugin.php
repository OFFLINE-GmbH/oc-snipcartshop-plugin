<?php namespace OFFLINE\SnipcartShop;

use Event;
use OFFLINE\SnipcartShop\Classes\ApiClient;
use OFFLINE\SnipcartShop\Classes\DiscountApi;
use OFFLINE\SnipcartShop\Classes\OrderCompleted;
use OFFLINE\SnipcartShop\Models\Category;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Translate'];

    public function registerComponents()
    {
        return [
            'OFFLINE\SnipcartShop\Components\Products'                  => 'products',
            'OFFLINE\SnipcartShop\Components\Product'                   => 'product',
            'OFFLINE\SnipcartShop\Components\Categories'                => 'categories',
            'OFFLINE\SnipcartShop\Components\CurrencyPicker'            => 'currencyPicker',
            'OFFLINE\SnipcartShop\Components\SnipcartDependencies'      => 'snipcartDependencies',
            'OFFLINE\SnipcartShop\Components\SnipcartCartButton'        => 'snipcartCartButton',
            'OFFLINE\SnipcartShop\Components\SnipcartCartSummary'       => 'snipcartCartSummary',
            'OFFLINE\SnipcartShop\Components\SnipcartCustomerDashboard' => 'snipcartCustomerDashboard',
        ];
    }

    public function registerSettings()
    {
        return [
            'general_settings'  => [
                'label'       => 'offline.snipcartshop::lang.plugin.general_settings.label',
                'description' => 'offline.snipcartshop::lang.plugin.general_settings.description',
                'category'    => 'offline.snipcartshop::lang.plugin.general_settings.category',
                'icon'        => 'icon-shopping-cart',
                'class'       => 'OFFLINE\SnipcartShop\Models\GeneralSettings',
                'order'       => 0,
                'permissions' => ['offline.snipcartshop.settings.manage_general'],
                'keywords'    => 'shop store snipcart general',
            ],
            'api_settings'      => [
                'label'       => 'offline.snipcartshop::lang.plugin.api_settings.label',
                'description' => 'offline.snipcartshop::lang.plugin.api_settings.description',
                'category'    => 'offline.snipcartshop::lang.plugin.general_settings.category',
                'icon'        => 'icon-exchange',
                'class'       => 'OFFLINE\SnipcartShop\Models\ApiSettings',
                'order'       => 10,
                'permissions' => ['offline.snipcartshop.settings.manage_api'],
                'keywords'    => 'shop store snipcart api',
            ],
            'currency_settings' => [
                'label'       => 'offline.snipcartshop::lang.plugin.currency_settings.label',
                'description' => 'offline.snipcartshop::lang.plugin.currency_settings.description',
                'category'    => 'offline.snipcartshop::lang.plugin.general_settings.category',
                'icon'        => 'icon-money',
                'class'       => 'OFFLINE\SnipcartShop\Models\CurrencySettings',
                'order'       => 20,
                'permissions' => ['offline.snipcartshop.settings.manage_currency'],
                'keywords'    => 'shop store snipcart currency',
            ],
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'OFFLINE\SnipcartShop\FormWidgets\VariantSelector' => 'variantselector',
        ];
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function () {
            (new DiscountApi())->updateDiscountUsages();
        })->hourly();
    }

    public function boot()
    {
        $this->registerWebhookEvents();
        $this->registerStaticPagesEvents();
    }

    protected function registerWebhookEvents()
    {
        Event::listen('snipcartshop.order.completed', OrderCompleted::class);
    }

    protected function registerStaticPagesEvents()
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
