<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category',
        'audience',
        'is_published',
        'publish_date',
        'expire_date'
    ];

    protected $casts = [
        'publish_date' => 'date',
        'expire_date' => 'date',
        'is_published' => 'boolean'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for active notices
    public function scopeActive($query)
    {
        return $query->where('is_published', true)
                     ->where('publish_date', '<=', now())
                     ->where(function($q) {
                         $q->whereNull('expire_date')
                           ->orWhere('expire_date', '>=', now());
                     });
    }

    // Scope by audience
    public function scopeForAudience($query, $audience)
    {
        return $query->where(function($q) use ($audience) {
            $q->where('audience', 'all')
              ->orWhere('audience', $audience);
        });
    }
}