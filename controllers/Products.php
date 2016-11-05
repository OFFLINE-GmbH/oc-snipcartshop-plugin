<?php namespace OFFLINE\SnipcartShop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use OFFLINE\SnipcartShop\FormWidgets\VariantSelector;

class Products extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.RelationController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('OFFLINE.SnipcartShop', 'snipcart-shop', 'snipcartshop-products');
    }
}