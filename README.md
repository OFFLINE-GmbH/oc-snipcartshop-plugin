# oc-snipcartshop-plugin
Ecommerce solution for October CMS using snipcart.com as a backend

## Installation

1. Add the snipcartshopDependencies component to your layouts. This component includes all needed js and css files from the snipcart servers. jQuery can be included optionally as well.

2. If you are using Rainlab.StaticPages, add a new menu entry of the type "all shop categories" to your navigation.  

3. Create a page and add the product list component to it's markup. If you want to filter the product category by url parameter don't forget to select "Get category from url" as category filter option. Give it a url like "/category/:slug*" (don't forget the star if you want to use subcategories). Select this page in your backend settings under "category page".

4. Create a page and add the product detail component to it's markup. Give it a url like "/product/:slug". Select this page in your backend settings under "product page".

5. If you are using discounts, make sure to set up [Task scheduling](http://octobercms.com/docs/plugin/scheduling) for your installation. This way the discount usage stats will get updated every hour.