<?php

namespace OFFLINE\SnipcartShop\Models;

use Model;
use Session;

class ApiSettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'offline_snipcartshop_settings';

    public $settingsFields = '$/offline/snipcartshop/models/settings/fields_api.yaml';

    public function getWebhookUrlAttribute()
    {
        if ( ! $url = ApiSettings::get('webhookUrl', false)) {
            $url = str_random(30);
            ApiSettings::set('webhookUrl', $url);
        }

        return $url;
    }
}