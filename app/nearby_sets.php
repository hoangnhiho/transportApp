<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class nearby_sets extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nearby_sets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nearbyset'];

}
