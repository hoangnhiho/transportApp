<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class event_patron extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'event_patron';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['event_id', 'patron_id', 'carthere', 'carback', 'leavingtime', 'softDelete'];

}
