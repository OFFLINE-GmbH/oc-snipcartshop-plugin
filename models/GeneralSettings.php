<?php

namespace OFFLINE\SnipcartShop\Models;

use Cms\Classes\Page;
use Model;
use Session;

class GeneralSettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'offline_snipcartshop_settings';

    public $settingsFields = '$/offline/snipcartshop/models/settings/fields_general.yaml';

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

}