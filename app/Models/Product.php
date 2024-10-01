<?php

namespace App\Models;

use App\Enums\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create($product)
 * @method static where(string $string, int|string|null $id)
 * @method static whereDate(string $string, string $format)
 */
class Product extends Model
{
    use HasFactory;


}
