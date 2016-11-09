<?php

namespace OFFLINE\SnipcartShop\Models;

use Cms\Classes\Page;
use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'offline_snipcartshop_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    /**
     * Returns all supported currency codes.
     */
    public static function currencies()
    {
        return collect(Settings::get('currencies'))->pluck('code', 'code');
    }

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }
}