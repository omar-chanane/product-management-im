<?php

namespace App\Models\ProductVariation;

use App\Models\ProductVariation\Traits\Attribute\ProductVariationAttribute;
use App\Models\ProductVariation\Traits\Method\ProductVariationMethod;
use App\Models\ProductVariation\Traits\Relationship\ProductVariationRelationship;
use App\Models\ProductVariation\Traits\Scope\ProductVariationScope;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use ProductVariationRelationship;
    use ProductVariationMethod;
    use ProductVariationScope;
    use ProductVariationAttribute;

    protected $table = 'product_variations';
    protected $fillable = [
        'name', 'value', 'product_id',
    ];
}
