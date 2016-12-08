<?php

namespace OFFLINE\SnipcartShop\Classes;

use Event;
use Illuminate\Http\Request;

/**
 * This class handles incomming webhooks from snipcart.com
 * and fire's the corresponding events.
 *
 * @package OFFLINE\SnipcartShop\Classes
 */
class WebhookProcessor
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        if ( ! starts_with($this->request->header('User-Agent'), 'Snipcart')) {
            throw new \InvalidArgumentException('The received request was not sent by Snipcart.com');
        }
    }

    public function process()
    {
        switch ($this->request->eventName) {
            case 'order.completed':
                return Event::fire('snipcartshop.order.completed', [$this->request->input('content')]);
        }
    }
}