<?php namespace OFFLINE\SnipcartShop;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'offline.snipcartshop::lang.plugin.settings.label',
                'description' => 'offline.snipcartshop::lang.plugin.settings.description',
                'category'    => 'offline.snipcartshop::lang.plugin.settings.category',
                'icon'        => 'icon-shop',
                'class'       => 'OFFLINE\SnipcartShop\Models\Settings',
                'order'       => 0,
                'keywords'    => 'shop store snipcart'
            ]
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'OFFLINE\SnipcartShop\FormWidgets\VariantSelector' => 'variantselector',
        ];
    }
}
