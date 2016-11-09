<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;
use OFFLINE\SnipcartShop\Models\Product as ProductModel;
use Redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Product extends ComponentBase
{
    use SetsVars;

    /**
     * The product to display.
     * @var ProductModel
     */
    public $product;

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.product.details.name',
            'description' => 'offline.snipcartshop::lang.components.product.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefix = 'offline.snipcartshop::lang.components.product.properties.';

        return [
            'productSlug' => [
                'title'       => $langPrefix . 'productSlug.title',
                'description' => $langPrefix . 'productSlug.description',
                'type'        => 'string',
                'default'     => '{{ :slug }}',
            ],
        ];
    }

    public function onRun()
    {
        try {
            $this->setVar('product', $this->loadProduct());
        } catch (NotFoundHttpException $e) {
            return Redirect::to('/404');
        }
    }

    protected function loadProduct()
    {
        $product = new ProductModel();

        $slug = $this->property('productSlug');

        $product = $product->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $product->transWhere('slug', $slug)
            : $product->where('slug', $slug);

        $product = $product->with(['main_image', 'images', 'custom_fields', 'custom_fields.options'])->first();

        if ( ! $product) {
            throw new NotFoundHttpException();
        }

        return $product;
    }
}