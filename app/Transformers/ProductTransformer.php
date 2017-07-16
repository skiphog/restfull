<?php

namespace App\Transformers;

use App\Product;
use App\Traits\TransformerAttribute;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    use TransformerAttribute;

    protected static $attributes = [
        'identifier'   => 'id',
        'title'        => 'name',
        'details'      => 'description',
        'stock'        => 'quantity',
        'situation'    => 'status',
        'picture'      => 'image',
        'seller'       => 'seller_id',
        'creationDate' => 'created_at',
        'lastChange'   => 'updated_at',
        'deleteDate'   => 'deleted_at'
    ];

    /**
     * A Fractal transformer.
     *
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'   => (int)$product->id,
            'title'        => (string)$product->name,
            'details'      => (string)$product->description,
            'stock'        => (int)$product->quantity,
            'situation'    => (string)$product->status,
            'picture'      => url('img/' . $product->image),
            'seller'       => (int)$product->seller_id,
            'creationDate' => (string)$product->created_at,
            'lastChange'   => (string)$product->updated_at,
            'deleteDate'   => isset($product->deleted_at) ? (string)$product->deleted_at : null,

            'links' => [
                [
                    'rel'  => 'self',
                    'href' => route('products.show', $product->id)
                ],
                [
                    'rel'  => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id)
                ],
                [
                    'rel'  => 'product.categories',
                    'href' => route('products.categories.index', $product->id)
                ],
                [
                    'rel'  => 'product.transactions',
                    'href' => route('products.transactions.index', $product->id)
                ],
                [
                    'rel'  => 'seller',
                    'href' => route('sellers.show', $product->seller_id)
                ],
            ]
        ];
    }
}
