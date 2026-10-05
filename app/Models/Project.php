<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder; // 1. Pastikan Builder di-import

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    /**
     * Local Scope untuk memfilter status published.
     * Penting: Nama method HARUS diawali dengan kata 'scope' (CamelCase)
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}