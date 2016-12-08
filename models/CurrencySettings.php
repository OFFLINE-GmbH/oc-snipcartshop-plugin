<?php

namespace OFFLINE\SnipcartShop\Models;

use Model;
use RuntimeException;
use Session;

class CurrencySettings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'offline_snipcartshop_settings';

    public $settingsFields = '$/offline/snipcartshop/models/settings/fields_currency.yaml';

    const CURRENCY_SESSION_KEY = 'snipcartshop.activeCurrency';

    /**
     * Returns all supported currency codes.
     */
    public static function currencies()
    {
        return collect(CurrencySettings::get('currencies'))->pluck('code', 'code');
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

}