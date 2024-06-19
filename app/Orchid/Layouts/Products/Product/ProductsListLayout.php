<?php

namespace App\Orchid\Layouts\Products\Product;

use App\Models\Product;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;

class ProductsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Название'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Product $product) {
                    return Link::make($product->name)
                        ->route('platform.product.edit', $product);
                }),
            TD::make('description', __('Описание'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Product $product) {
                    return $product->description;
                }),
            TD::make('price', __('Цена'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Product $product) {
                    return $product->price;
                }),
            TD::make('category_id', __('Категория'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Product $product) {
                    return $product->category->name;
                }),
        ];
    }
}
