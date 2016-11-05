<?php namespace OFFLINE\SnipcartShop;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function registerFormWidgets()
    {
        return [
            'OFFLINE\SnipcartShop\FormWidgets\VariantSelector' => 'variantselector',
        ];
    }
}
