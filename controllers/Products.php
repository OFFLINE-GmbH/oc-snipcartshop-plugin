<?php namespace OFFLINE\SnipcartShop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Products extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.RelationController',
    ];

    public $requiredPermissions = ['offline.snipcartshop.manage_products'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('OFFLINE.SnipcartShop', 'snipcart-shop', 'snipcartshop-products');
    }

    public function create()
    {
        $this->bodyClass = 'compact-container';
        parent::create();
    }

    public function update($recordId = null)
    {
        $this->bodyClass = 'compact-container';
        parent::update($recordId);
    }
}