<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status',
        'priority',
        'category',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the support ticket
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the responses for the support ticket
     */
    public function responses()
    {
        return $this->hasMany(SupportResponse::class);
    }
}
