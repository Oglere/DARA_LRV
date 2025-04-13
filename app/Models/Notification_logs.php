<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification_logs extends Model
{
    use HasFactory;

    protected $table = 'notification_logs';
    protected $primaryKey = 'notification_id';
    public $timestamps = false;
    
    protected $fillable = [
        'email',
        'is_checked',
    ];
}
