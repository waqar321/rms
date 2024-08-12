<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;

class LectureMobileUserRecord extends Model
{
    use HasFactory, CommonRelations;
    protected $table = 'lecture_mobile_user_records';
    
    protected $fillable = ['lecture_id', 'user_id', 'status'];
    public function lecture()
    {
        return $this->belongsTo(ecom_lecture::class, 'lecture_id');
    }
    public function user()
    {
        return $this->belongsTo(ecom_admin_user::class, 'id', 'user_id');
    }
}
