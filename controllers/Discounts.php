<?php namespace OFFLINE\SnipcartShop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Discounts extends Controller
{
    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['offline.snipcartshop.manage_discounts'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('OFFLINE.SnipcartShop', 'snipcart-shop', 'snipcartshop-discounts');
    }
}