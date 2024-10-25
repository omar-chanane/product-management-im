<?php

namespace App\Models\Product\Traits\Relationship;


use App\Models\ProductVariation\ProductVariation;

/**
 * Class ProductVariationRelationship.
 */
trait ProductRelationship
{
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
