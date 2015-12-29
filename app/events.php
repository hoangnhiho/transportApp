<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class events extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'datetime', 'password'];

	public function patrons()
	{
		return $this->belongsToMany('App\patrons');
	}

}
