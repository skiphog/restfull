<?php

namespace App\Transformers;

use App\Category;
use App\Traits\TransformerAttribute;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    use TransformerAttribute;

    protected static $attributes = [
        'identifier'   => 'id',
        'title'        => 'name',
        'details'      => 'description',
        'isVerified'   => 'verified',
        'creationDate' => 'created_at',
        'lastChange'   => 'updated_at',
        'deleteDate'   => 'deleted_at'
    ];

    /**
     * A Fractal transformer.
     *
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier'   => (int)$category->id,
            'title'        => (string)$category->name,
            'details'      => (string)$category->description,
            'creationDate' => (string)$category->created_at,
            'lastChange'   => (string)$category->updated_at,
            'deleteDate'   => isset($category->deleted_at) ? (string)$category->deleted_at : null,

            'links' => [
                [
                    'rel'  => 'self',
                    'href' => route('categories.show', $category->id)
                ],
                [
                    'rel'  => 'category.buyers',
                    'href' => route('categories.buyers.index', $category->id)
                ],
                [
                    'rel'  => 'category.products',
                    'href' => route('categories.products.index', $category->id)
                ],
                [
                    'rel'  => 'category.sellers',
                    'href' => route('categories.sellers.index', $category->id)
                ],
                [
                    'rel'  => 'category.transactions',
                    'href' => route('categories.transactions.index', $category->id)
                ],
            ]
        ];
    }
}
