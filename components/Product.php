<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Flash;
use OFFLINE\SnipcartShop\Models\CurrencySettings;
use OFFLINE\SnipcartShop\Models\GeneralSettings;
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
    /**
     * If the snipcart overlay will open automatically.
     * @var boolean
     */
    public $autoPop;
    /**
     * Reference to the page name for linking to products.
     * @var string
     */
    public $productPage;
    /**
     * Show custom fields directly on the product page.
     * @var boolean
     */
    public $displayCustomFields;

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.product.details.name',
            'description' => 'offline.snipcartshop::lang.components.product.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefixProduct  = 'offline.snipcartshop::lang.components.product.properties.';
        $langPrefixProducts = 'offline.snipcartshop::lang.components.products.properties.';

        return [
            'productSlug'         => [
                'title'       => $langPrefixProduct . 'productSlug.title',
                'description' => $langPrefixProduct . 'productSlug.description',
                'type'        => 'string',
                'default'     => '{{ :slug }}',
            ],
            'productPage'         => [
                'title'       => $langPrefixProducts . 'productPage.title',
                'description' => $langPrefixProducts . 'productPage.description',
                'type'        => 'dropdown',
                'default'     => '',
            ],
            'displayCustomFields' => [
                'title'       => $langPrefixProducts . 'displayCustomFields.title',
                'description' => $langPrefixProducts . 'displayCustomFields.description',
                'type'        => 'checkbox',
                'default'     => false,
            ],
        ];
    }

    public function getProductPageOptions()
    {
        return [null => '(' . trans('offline.snipcartshop::lang.plugin.common.use_backend_defaults') . ')']
            + Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    public function onRun()
    {
        try {
            $this->setVar('product', $this->loadProduct());
            $this->setVar('productPage', $this->getProductPage());
            $this->setVar('autoPop', GeneralSettings::get('auto_pop', true));
            $this->setVar('displayCustomFields', (bool)$this->property('displayCustomFields', false));
        } catch (NotFoundHttpException $e) {
            return Redirect::to('/404');
        }

        $this->setMetaData();
    }

    public function onAdd()
    {
        Flash::success(trans('offline.snipcartshop::lang.components.product.added_to_cart'));
    }

    public function onRecalculatePrice()
    {
        $price    = post('price');

        return format_money($price, $this->product);
    }

    protected function loadProduct()
    {
        $product = new ProductModel();

        $slug = $this->property('productSlug');

        $product = $product->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $product->transWhere('slug', $slug)
            : $product->where('slug', $slug);

        $product = $product->with([
            'main_image',
            'images',
            'downloads',
            'accessories',
            'custom_fields',
            'custom_fields.options',
        ])->first();

        if ( ! $product) {
            throw new NotFoundHttpException();
        }

        return $product;
    }

    protected function setMetaData()
    {
        $this->page->title = $this->product->meta_title
            ? $this->product->meta_title
            : $this->product->name;

        if ($this->product->meta_description) {
            $this->page->meta_description = $this->product->meta_description;
        }
    }

    private function getProductPage()
    {
        if ($this->property('productPage')) {
            return $this->property('productPage');
        }

        return GeneralSettings::get('product_page');
    }
}