<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdlPolicy extends Model {

	protected $table = "tbl_policy";

	protected $fillable = [
			'policy_no',
			'firstname',
			'middlename',
			'lastname',
			'address',
			'phone',
			'date_from',
			'date_to',
			'vehicle_type',
			'vehicle_color',
			'vehicle_platenumber',
			'vehicle_orcr',
			'vehicle_seats'
	];
	
	
}