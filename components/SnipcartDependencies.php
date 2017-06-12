<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;
use OFFLINE\SnipcartShop\Models\ApiSettings;
use OFFLINE\SnipcartShop\Models\CurrencySettings;
use OFFLINE\SnipcartShop\Models\GeneralSettings;

class SnipcartDependencies extends ComponentBase
{
    use SetsVars;

    /**
     * SnipCart API Key.
     * @var string
     */
    public $apiKey = '';
    /**
     * Opens the cart after adding a product.
     * @var boolean
     */
    public $autoPop = true;
    /**
     * Show an option to continue shopping.
     * @var boolean
     */
    public $showContinueShopping = false;
    /**
     * Use separate fields for First name and Last name.
     * @var boolean
     */
    public $splitFirstNameAndLastName = false;
    /**
     * Include jQuery from code.query.com.
     * @var boolean
     */
    public $includeJquery = false;
    /**
     * Currently active currency.
     * @var string
     */
    public $activeCurrency = [];

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.dependencies.details.name',
            'description' => 'offline.snipcartshop::lang.components.dependencies.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefix = 'offline.snipcartshop::lang.components.dependencies.properties.';

        return [
            'includeJquery' => [
                'title'       => $langPrefix . 'include_jquery.title',
                'description' => $langPrefix . 'include_jquery.description',
                'type'        => 'checkbox',
                'default'     => false,
            ],
        ];
    }

    public function onRun()
    {
        $this->setVar('apiKey', ApiSettings::get('public_api_key', ''));
        $this->setVar('autoPop', GeneralSettings::get('auto_pop', true));
        $this->setVar('showContinueShopping', GeneralSettings::get('show_continue_shopping', false));
        $this->setVar('splitFirstNameAndLastName', GeneralSettings::get('split_firstname_and_lastname', false));
        $this->setVar('activeCurrency', CurrencySettings::activeCurrency());
        $this->setVar('includeJquery', $this->property('includeJquery'));
    }

}