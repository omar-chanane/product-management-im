<?php

namespace App\Models\ProductVariation\Traits\Relationship;


use App\Models\Product\Product;

/**
 * Class ProductVariationRelationship.
 */
trait ProductVariationRelationship
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
