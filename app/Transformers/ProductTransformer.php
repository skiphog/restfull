<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
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
        ];
    }
}
