<?php

namespace App\Models;

use App\Enums\QuotationStatus;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static max(string $string)
 * @method static whereDate(string $string, string $format)
 * @method static where(string $string, int|string|null $id)
 * @method static create(array $array)
 */
class Quotation extends Model
{

}
