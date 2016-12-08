<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;

class SnipcartCartButton extends ComponentBase
{
    use SetsVars;

    /**
     * Label to display on the checkout button.
     *
     * @var string
     */
    public $buttonLabel;

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.cartButton.details.name',
            'description' => 'offline.snipcartshop::lang.components.cartButton.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefix = 'offline.snipcartshop::lang.components.cartButton.properties.';

        return [
            'buttonLabel' => [
                'title'       => $langPrefix . 'buttonLabel.title',
                'description' => $langPrefix . 'buttonLabel.description',
                'type'        => 'string',
                'default'     => 'Click here to checkout',
            ],
        ];
    }

    public function onRun()
    {
        $this->setVar('buttonLabel', $this->property('buttonLabel'));
    }

}