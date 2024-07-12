<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;

class ecom_notifications_status extends Model
{
    use HasFactory, SoftDeletes, CommonRelations;

    protected $table = 'notifications_status';

    protected $fillable = [
        'notification_id',    
        'user_id',    
        'device_token',    
        'seen',    
        'read'    
    ];   
}

