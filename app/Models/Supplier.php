<?php

namespace App\Models;

use App\Enums\SupplierType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'shopname', 'type', 'photo', 'account_holder', 'account_number', 'bank_name', 'user_id', 'uuid'
    ];

    protected $casts = [
        'type' => SupplierType::class,
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, string $search = null)
    {
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }
        return $query;
    }
    public function getRouteKeyName()
    {
        return 'uuid'; // This ensures that the model is resolved using the UUID
    }


}
