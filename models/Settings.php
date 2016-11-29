<?php

namespace OFFLINE\SnipcartShop\Models;

use Cms\Classes\Page;
use Model;
use RuntimeException;
use Session;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'offline_snipcartshop_settings';

    public $settingsFields = 'fields.yaml';

    const CURRENCY_SESSION_KEY = 'snipcartshop.activeCurrency';

    /**
     * Returns all supported currency codes.
     */
    public static function currencies()
    {
        return collect(Settings::get('currencies'))->pluck('code', 'code');
    }

    /**
     * Returns the currently active currency from the session.
     * @return string
     * @throws \RuntimeException
     */
    public static function activeCurrency()
    {
        if ( ! Session::has(static::CURRENCY_SESSION_KEY)) {
            $currencies = static::currencies();
            if ($currencies->count() < 1) {
                throw new RuntimeException(
                    '[snipcartshop] Please configure at least one currency via the backend settings.'
                );
            }

            static::setActiveCurrency($currencies->first());
        }

        return Session::get(static::CURRENCY_SESSION_KEY);
    }

    /**
     * Sets the currently active currency in the session.
     * @return string
     */
    public static function setActiveCurrency($currency)
    {
        return Session::set(static::CURRENCY_SESSION_KEY, $currency);
    }

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    public function getWebhookUrlAttribute()
    {
        if ( ! $url = Settings::get('webhookUrl', false)) {
            $url = str_random(30);
            Settings::set('webhookUrl', $url);
        }

        return $url;
    }
}