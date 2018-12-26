<?php

namespace App\Repositories\Backend;

use App\Models\Backend\shop;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class shopRepository
 * @package App\Repositories\Backend
 * @version December 23, 2018, 11:36 pm UTC
 *
 * @method shop findWithoutFail($id, $columns = ['*'])
 * @method shop find($id, $columns = ['*'])
 * @method shop first($columns = ['*'])
*/
class shopRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'icon',
        'lng',
        'lat',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return shop::class;
    }

    /** 
     * Upload the Icon
     **/
    public function uploadImage($image){

        if($image->isValid())
        {
            $path = $image->store('shops', 'public');
        }
        return $path;
    }
}
