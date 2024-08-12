<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $table = 'successful_emails';

    protected $fillable = [
        'affiliate_id',
        'envelope',
        'from',
        'subject',
        'dkim',
        'SPF',
        'spam_score',
        'email',
        'raw_text',
        'sender_ip',
        'to',
        'timestamp',
        'processed',
        'deleted',
    ];

    protected $casts = [
        'processed' => 'boolean',
        'deleted' => 'boolean',
        'spam_score' => 'float',
    ];
}