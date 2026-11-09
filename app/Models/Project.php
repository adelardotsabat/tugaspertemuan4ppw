<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'category_id',   // ➕
        'thumbnail',     // ➕ WAJIB, kalau tidak thumbnail tidak tersimpan
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    // ➕
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ➕
    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}