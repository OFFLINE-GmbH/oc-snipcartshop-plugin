<?php namespace OFFLINE\SnipcartShop\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use OFFLINE\SnipcartShop\Models\Category;
use OFFLINE\SnipcartShop\Models\GeneralSettings;
use OFFLINE\SnipcartShop\Models\Product;
use Redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Products extends ComponentBase
{
    use SetsVars;

    /**
     * A collection of products to display
     * @var Collection
     */
    public $products;

    /**
     * If the product list should be filtered by a category, the model to use.
     * @var Model
     */
    public $category;

    /**
     * If the category is filtered via slug use this parameter.
     * @var string
     */
    public $categoryParam;

    /**
     * Message to display when there are no products.
     * @var string
     */
    public $noProductsMessage;

    /**
     * Reference to the page name for linking to products.
     * @var string
     */
    public $productPage;

    /**
     * If the product list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    public function componentDetails()
    {
        return [
            'name'        => 'offline.snipcartshop::lang.components.products.details.name',
            'description' => 'offline.snipcartshop::lang.components.products.details.description',
        ];
    }

    public function defineProperties()
    {
        $langPrefix = 'offline.snipcartshop::lang.components.products.properties.';

        return [
            'categoryFilter'    => [
                'title'       => $langPrefix . 'categoryFilter.title',
                'description' => $langPrefix . 'categoryFilter.description',
                'type'        => 'dropdown',
                'default'     => 'slug',
            ],
            'categorySlug'      => [
                'title'       => $langPrefix . 'categorySlug.title',
                'description' => $langPrefix . 'categorySlug.description',
                'type'        => 'string',
                'default'     => '{{ :slug }}',
            ],
            'productsPerPage'   => [
                'title'             => $langPrefix . 'productsPerPage.title',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => $langPrefix . '',
                'default'           => '9',
            ],
            'noProductsMessage' => [
                'title'             => $langPrefix . 'noProductsMessage.title',
                'description'       => $langPrefix . 'noProductsMessage.description',
                'type'              => 'string',
                'default'           => 'No Products found.',
                'showExternalParam' => false,
            ],
            'sortOrder'         => [
                'title'       => $langPrefix . 'sortOrder.title',
                'description' => $langPrefix . 'sortOrder.description',
                'type'        => 'dropdown',
                'default'     => 'published_at desc',
            ],
            'productPage'       => [
                'title'       => $langPrefix . 'productPage.title',
                'description' => $langPrefix . 'productPage.description',
                'type'        => 'dropdown',
                'default'     => '',
            ],
        ];
    }

    public function onRun()
    {
        $this->mapProperties();

        try {
            $this->setVar('category', $this->loadCategory());
            $this->setVar('products', $this->loadProducts());
            $this->validatePageNumber();

        } catch (NotFoundHttpException $e) {
            return Redirect::to('/404');
        }

        $this->setMetaData();
    }

    protected function loadProducts()
    {
        $products = $this->category
            ? $this->category->products()->published()
            : Product::published();

        return $products->paginate($this->property('productsPerPage', 10));
    }

    protected function loadCategory()
    {
        $categoryId = $this->property('categoryFilter');
        if ( ! $categoryId || $categoryId === 'all') {
            return null;
        }

        $category = new Category();

        // Use the category slug from the URL
        if ($categoryId === 'slug') {
            $slug = $this->property('categorySlug');

            $category = $category->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
                ? $category->transWhere('slug', $slug)
                : $category->where('slug', $slug);
        } else {
            $category = $category->whereId($categoryId);
        }

        $category = $category->with([
            'products',
            'products.images',
            'products.main_image',
        ])->first();

        if ( ! $category) {
            throw new NotFoundHttpException();
        }

        return $category;
    }

    protected function mapProperties()
    {
        $this->setVar('pageParam', $this->paramName('pageNumber'));
        $this->setVar('categoryParam', $this->paramName('categorySlug'));
        $this->setVar('noProductsMessage', $this->property('noProductsMessage'));
        $this->setVar('productPage', $this->getProductPage());
    }

    public function getCategoryFilterOptions()
    {
        $categories = Category::listsNested('name', 'id', '-- ');
        // If no array is returned there are no categories
        // created yet. So let's use an empty array for now.
        if ( ! is_array($categories)) {
            $categories = [];
        }

        return [
                'all'  => trans('offline.snipcartshop::lang.components.products.properties.categoryFilter.no_filter'),
                'slug' => trans('offline.snipcartshop::lang.components.products.properties.categoryFilter.by_slug'),
            ] + $categories;
    }

    public function getSortOrderOptions()
    {
        return Category::allowedSortingOptions();
    }

    public function getProductPageOptions()
    {
        return [null => '(' . trans('offline.snipcartshop::lang.plugin.common.use_backend_defaults') . ')']
            + Page::sortBy('baseFileName')->lists('title', 'baseFileName');
    }

    protected function validatePageNumber()
    {
        if ($pageNumberParam = input('page')) {
            $currentPage = input('page');

            if ($currentPage > ($lastPage = $this->products->lastPage()) && $currentPage > 1) {
                throw new NotFoundHttpException();
            }
        }
    }

    private function getProductPage()
    {
        if ($this->property('productPage')) {
            return $this->property('productPage');
        }

        return GeneralSettings::get('product_page');
    }

    protected function setMetaData()
    {
        if ( ! $this->category) {
            return;
        }

        $this->page->title = $this->category->meta_title
            ? $this->category->meta_title
            : $this->category->name;

        if ($this->category->meta_description) {
            $this->page->meta_description = $this->category->meta_description;
        }
    }

}