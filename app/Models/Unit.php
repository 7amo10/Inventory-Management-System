<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, int|string|null $id)
 */
class Unit extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    protected $filable =[
        'name',
        'slug',
        'short_code',
        'user_id',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function products(){
        return $this->hasMany(Product::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('slug', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('short_code', 'like', "%{$value}%");
    }


}
