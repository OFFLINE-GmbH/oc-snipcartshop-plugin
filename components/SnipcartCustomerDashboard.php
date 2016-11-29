<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;

class SnipcartCustomerDashboard extends ComponentBase
{
    use SetsVars;

    public $customerDashboardLabel = '';
    public $logoutLabel = '';

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.customerDashboard.details.name',
            'description' => 'offline.snipcartshop::lang.components.customerDashboard.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefix = 'offline.snipcartshop::lang.components.customerDashboard.properties.';

        return [
            'customerDashboardLabel' => [
                'title'       => $langPrefix . 'customerDashboardLabel.title',
                'description' => $langPrefix . 'customerDashboardLabel.description',
                'type'        => 'text',
                'default'     => 'Customer Dashboard',
            ],
            'logoutLabel'            => [
                'title'       => $langPrefix . 'logoutLabel.title',
                'description' => $langPrefix . 'logoutLabel.description',
                'type'        => 'text',
                'default'     => 'Logout',
            ],
        ];
    }

    public function onRun()
    {
        $this->setVar('customerDashboardLabel', $this->property('customerDashboardLabel'));
        $this->setVar('logoutLabel', $this->property('logoutLabel'));
    }

}