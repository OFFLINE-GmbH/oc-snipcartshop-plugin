<?php
use Illuminate\Http\Request;
use OFFLINE\SnipcartShop\Models\ApiSettings;

Route::post('/snipcartshop/webhook/{id}', function (Request $request, $id) {
    if (ApiSettings::get('webhookUrl') !== $id) {
        return response('', 404);
    }

    $processor = new \OFFLINE\SnipcartShop\Classes\WebhookProcessor($request);
    $processor->process();

    return response('', 200);
});