<?php namespace OFFLINE\SnipcartShop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use October\Rain\Exception\ValidationException;
use OFFLINE\SnipcartShop\Classes\OrderApi;
use OFFLINE\SnipcartShop\Models\Order;

class Orders extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ImportExportController',
    ];

    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public $requiredPermissions = ['offline.snipcartshop.manage_orders'];
    /**
     * @var OrderApi
     */
    private $api;

    public function __construct(OrderApi $api)
    {
        parent::__construct();
        BackendMenu::setContext('OFFLINE.SnipcartShop', 'snipcart-shop', 'snipcartshop-orders');

        $this->api = $api;
    }

    public function show()
    {
        $this->bodyClass = 'compact-container';
        $this->pageTitle = trans('offline.snipcartshop::lang.plugin.titles.orders.show');
        $this->addCss('/plugins/offline/snipcartshop/assets/backend.css');

        $order               = Order::with('items')->findOrFail($this->params[0]);
        $this->vars['order'] = $order;
    }

    /**
     * @throws ValidationException
     */
    public function onChangeOrderStatus()
    {
        $status          = input('status');
        $availableStatus = trans('offline.snipcartshop::lang.plugin.order_status');
        if ( ! array_key_exists($status, $availableStatus)) {
            throw new ValidationException([trans('offline.snipcartshop::lang.plugin.order.invalid_status')]);
        }

        $this->updateOrder(['status' => $status]);

        return [
            '#order_status' => $availableStatus[$status],
        ];
    }


    public function onChangePaymentStatus()
    {
        $status          = input('status');
        $availableStatus = trans('offline.snipcartshop::lang.plugin.payment_status');
        if ( ! array_key_exists($status, $availableStatus)) {
            throw new ValidationException([trans('offline.snipcartshop::lang.plugin.order.invalid_status')]);
        }

        $this->updateOrder(['payment_status' => $status]);

        return [
            '#payment_status' => $availableStatus[$status],
        ];
    }

    public function onUpdateTrackingInfo()
    {
        $trackingNumber = input('trackingNumber');
        $trackingUrl    = input('trackingUrl');

        $this->updateOrder(['tracking_url' => $trackingUrl, 'tracking_number' => $trackingNumber]);
    }

    protected function updateOrder(array $attributes)
    {
        $order = Order::findOrFail(input('id'));
        $order->forceFill($attributes);

        $this->api->update($order);

        $order->save();
        Flash::success(trans('offline.snipcartshop::lang.plugin.order.updated'));
    }

    protected function formatTaxRate($rate)
    {
        return sprintf("%.2f%%", (float)$rate * 100);
    }
}