<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    public function images(): HasMany
    {
        return $this->hasMany(Image::class)->orderBy('created_at');
    }

    protected $fillable = [
        'id', 'image_id_long', 'product_name', 'product_description', 'operating_system', 'category', 'ram', 'display_size', 'price',
    ];
}
