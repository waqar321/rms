<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory, SoftDeletes, CommonRelations;

    protected $table = 'zone';
    
    protected $fillable = [
        'zone_code',
        'zone_name',
        'zone_short_name',     
    ];
}


// $zone = new Zone();
// $zone->zone_code = $zone_code;
// $zone->zone_name = $zone_name;
// $zone->zone_short_name = $zone_short_name;
// $zone->save();