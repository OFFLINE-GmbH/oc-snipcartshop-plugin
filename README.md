# oc-snipcartshop-plugin

Ecommerce solution for October CMS using snipcart.com as a backend.

**Demo:** [https://snipcart.offline.swiss](https://snipcart.offline.swiss)

> Please note: this plugin is not affiliated with Snipcart directly. It simply provides an easy way to use the third-party e-commerce service with October CMS. Therefore, Snipcart-specific questions may need to be directly put through Snipcart's support. We'll provide support for plugin-specific questions, and plugin maintenance.


## Features

* Multi-currency
* Multi-language (via Rainlab.Translate, Backend available in german and english)
* Discounts and coupon codes
* Inventory management
* Product attributes and variants
* Product links and downloads 
* Update orders directly from the October CMS backend
* [OFFLINE.SiteSearch](https://octobercms.com/plugin/offline-sitesearch) support
* Fully functional and responsive [demo theme](https://github.com/OFFLINE-GmbH/oc-snipcartshop-theme) ready to download 

### Quickstart

1. Create an account on [snipcart.com](http://snipcart.com)
1. Add the `snipcartshopDependencies` component to your layouts. This component includes all needed js and css files from the snipcart servers. jQuery can be included optionally as well.
1. If you are using Rainlab.StaticPages, add a new menu entry of the type `all shop categories` to your navigation.  
1. Create a page and add the `products` component to it's markup. If you want to filter the product category by url parameter don't forget to select "Get category from url" as category filter option. Give it a url like `/category/:slug*` (don't forget the star if you want to use subcategories). Select this page in the plugin's backend settings under `category page`.
1. Create a page and add the `product` component to it's markup. Give it a url like `/product/:slug`. Select this page in the plugin's backend settings under `product page`.
1. Setup at least one currency in the plugin's backend settings. Set up the same currencies in your Snipcart dashboard under [Account / Regional Settings](https://app.snipcart.com/dashboard/settings/regional).
1. If you are using discounts, make sure to set up [Task scheduling](http://octobercms.com/docs/plugin/scheduling) for your October installation. This way the discount usage stats will get updated every hour.
1. Create a public and a private API key in your Snipcart dashboard under [Account / Credentials](https://app.snipcart.com/dashboard/account/credentials). Paste both keys in the respective input field in the plugin's backend settings.
1. Copy your custom webhook URL from the plugin's backend settings (under API and webhooks). Set the URL as Webhooks URL in your Snipcart dashboard under [Account / Webhooks](https://app.snipcart.com/dashboard/webhooks)

### Custom currency format

Starting with version 1.0.32 you are able to specify a custom currency format in the backend settings.
The code you provide is parsed as a Twig template so all the functionality of Twig is available. 

If you do not enter a specific format the following will be used

    {{ currency }} {{ price|number_format(2, '.', '\'') }}
    
The following variables are available

<table class="table">
    <thead>
    <tr>
        <th>Variable</th>
        <th>Description</th>
        <th>Example value</th>
    </tr>
    </thead>
    <tr>
        <td><code>price</code></td>
        <td>The full price of the product as float</td>
        <td>1500.40</td>
    </tr>
    <tr>
        <td><code>integers</code></td>
        <td>The price without decimals</td>
        <td>1500</td>
    </tr>
    <tr>
        <td><code>decimals</code></td>
        <td>Only the decimals of the price</td>
        <td>40</td>
    </tr>
    <tr>
        <td><code>currency</code></td>
        <td>The currency code you specified above</td>
        <td>EUR</td>
    </tr>
    <tr>
        <td><code>product</code></td>
        <td>The product model this price is from.</td>
        <td>A full model instance</td>
    </tr>
</table>

These are a few example usages:

```twig
{{ currency }} {{ price|number_format(2, '.', '\'') }}

-> EUR 1'200.40
```
```twig
<span class="integers">{{ integers }}</span>    
<span class="separator">,</span>    
<span class="decimals">{{ decimals }}</span>    
<span class="currency">{{ currency }}</span>  
  
-> 1200,40 EUR
```
```twig
{{ price|number_format(2, '.', '\'') }} {{ currency }} 

{% if (product.taxable) %}
    (VAT included)
{% else %}
    (VAT excluded)
{% endif %}

-> 1200,40 EUR (VAT included)
```