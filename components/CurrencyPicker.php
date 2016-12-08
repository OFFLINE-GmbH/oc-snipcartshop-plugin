<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Collection;
use OFFLINE\SnipcartShop\Models\CurrencySettings;
use Redirect;

class CurrencyPicker extends ComponentBase
{
    use SetsVars;

    /**
     * Configured currencies for this shop.
     * @var Collection
     */
    public $currencies = [];
    /**
     * Currently active currency.
     * @var string
     */
    public $activeCurrency = [];

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.currencyPicker.details.name',
            'description' => 'offline.snipcartshop::lang.components.currencyPicker.details.description',
        ];
    }

    public function onRun()
    {
        $this->setVar('currencies', CurrencySettings::currencies());
        $this->setVar('activeCurrency', CurrencySettings::activeCurrency());
    }

    public function onSwitchCurrency()
    {
        if ( ! $locale = post('currency')) {
            return;
        }

        CurrencySettings::setActiveCurrency($locale);

        return Redirect::back();
    }

}