<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class patrons extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patrons';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'picurl', 'address', 'suburb', 'postcode'];
	
	public function events()
	{
		return $this->belongsToMany('App\events');
	}

}
