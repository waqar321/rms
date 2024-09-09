<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;

class SideBar extends Model
{
    
    
    use HasFactory, CommonRelations, SoftDeletes;

    protected $table = 'menus';

    protected $fillable = [
                        'title',
                        'icon',
                        'url',
                        'order',
                        'IdNames',
                        'ClassNames',
                        'parent_id',
                        'permission_id',
                        'is_active'
                    ];

    protected $casts = [
        'IdNames' => 'array',
        'ClassNames' => 'array',
    ];

    /*    $casts
     Attributes should be treated as arrays when retrieving them from the database and setting them on the model. 
     This means that Laravel will automatically serialize these attributes to JSON when saving them to the database, 
     and deserialize them back into PHP arrays when retrieving them from the databas
     Laravel will handle the JSON encoding and decoding automatically due to the casting defined in the model while assining value
    */

    public function ParentMenu()
    {
        return $this->belongsTo(SideBar::class, 'parent_id');
    }
    public function Permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
    public function subMenus()
    {
        return $this->hasMany(SideBar::class, 'parent_id')->where('is_active', 1)->orderBy('order');
        // return $this->hasMany(SideBar::class, 'parent_id');
    }


}
