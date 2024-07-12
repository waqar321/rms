<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class central_ops_branch extends Model {

    protected $table = 'central_ops_branch';
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s"
    ];

}
