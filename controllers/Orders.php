<?php namespace OFFLINE\SnipcartShop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use OFFLINE\SnipcartShop\Models\Order;

class Orders extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
    ];

    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['offline.snipcartshop.manage_orders'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('OFFLINE.SnipcartShop', 'snipcart-shop', 'snipcartshop-orders');
    }

    public function show()
    {
        $this->bodyClass = 'compact-container';
        $this->addCss('/plugins/offline/snipcartshop/assets/backend.css');

        $order               = Order::with('items')->findOrFail($this->params[0]);
        $this->vars['order'] = $order;
    }

    public function onChangeStatus()
    {
        dd($this);
    }

    public function onRefund()
    {
        dd($this);
    }

    protected function formatTaxRate($rate)
    {
        return sprintf("%.2f%%", (float)$rate * 100);
    }
}