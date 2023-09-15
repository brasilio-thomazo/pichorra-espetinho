<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($v) {
                $file = Storage::url("image.png");
                if ($v) {
                    $file = Storage::url($v);
                }
                return sprintf("%s%s", env("APP_URL"), $file);
            }
        );
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
