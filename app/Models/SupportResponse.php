<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'response_text',
        'is_admin_response',
    ];

    protected $casts = [
        'is_admin_response' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the support ticket
     */
    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    /**
     * Get the user that made the response
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
