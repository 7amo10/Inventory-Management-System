<?php

namespace App\Models;

use App\Enums\PurchaseStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static where(string $string, int|string|null $id)
 * @method static whereDate(string $string, string $format)
 * @method static create(array $array)
 * @method static findOrFail($id)
 */
class Purchase extends Model
{
    use HasFactory;


}
