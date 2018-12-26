<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * Class shop
 * @package App\Models\Backend
 * @version December 23, 2018, 11:36 pm UTC
 *
 * @property string name
 * @property string description
 * @property string icon
 * @property double lng
 * @property double lat
 * @property string slug
 */
class shop extends Model
{
    use SoftDeletes;
    use Sluggable;

     /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public $table = 'shops';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'icon',
        'lng',
        'lat',
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'icon' => 'string',
        'lng' => 'double',
        'lat' => 'double',
        'slug' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'lng' => 'required',
        'lat' => 'required'
    ];
    
}
