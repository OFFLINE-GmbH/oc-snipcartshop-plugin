<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;

class SnipcartCartSummary extends ComponentBase
{
    use SetsVars;

    /**
     * Display total count of items in cart.
     *
     * @var bool
     */
    public $showItemCount = true;
    /**
     * Display total price of items in cart.
     *
     * @var bool
     */
    public $showTotalPrice = true;

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.cartSummary.details.name',
            'description' => 'offline.snipcartshop::lang.components.cartSummary.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefix = 'offline.snipcartshop::lang.components.cartSummary.properties.';

        return [
            'showItemCount'  => [
                'title'       => $langPrefix . 'showItemCount.title',
                'description' => $langPrefix . 'showItemCount.description',
                'type'        => 'checkbox',
                'default'     => true,
            ],
            'showTotalPrice' => [
                'title'       => $langPrefix . 'showTotalPrice.title',
                'description' => $langPrefix . 'showTotalPrice.description',
                'type'        => 'checkbox',
                'default'     => true,
            ],
        ];
    }

    public function onRun()
    {
        $this->setVar('showItemCount', (bool)$this->property('showItemCount'));
        $this->setVar('showTotalPrice', (bool)$this->property('showTotalPrice'));
    }

}