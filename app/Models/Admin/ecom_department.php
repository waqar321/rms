<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ecom_department extends Model 
{
    use HasFactory, SoftDeletes;
 
    // User::withTrashed()->get();    //all including trashed,
    // User::onlyTrashed()->get();    // only deleted users
    // User::onlyTrashed()->whereId(2)->restore();   //get id 2 trashed user and restore him
    // User::first()->forcedelete();   //delete permanently

    protected $table = 'ecom_department';
    protected $fillable = [
        'department_id',
        'sub_department_id',
        'name',
        'description',
        'office_location',
        'parent_id',
        'is_active',
        'is_deleted',
    ];
    
    public function parentDepartment()
    {
        return $this->belongsTo(ecom_department::class, 'parent_id');
    }

    public function childDepartments()
    {
        return $this->hasMany(ecom_department::class, 'parent_id');
    }
}
