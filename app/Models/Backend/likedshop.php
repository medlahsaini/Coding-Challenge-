<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class shop
 * @package App\Models\Backend
 * @version December 24, 2018, 11:36 pm UTC
 *
 * @property integer user_id
 * @property integer shop_id
 */
class likedshop extends Model
{
    use SoftDeletes;

    public $table = 'likedshops';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'shop_id',
        'liked'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'shop_id' => 'integer',
        'liked' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'shop_id' => 'required'
    ];

    
}
