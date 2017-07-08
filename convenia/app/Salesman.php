<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salesman extends Model
{
	use SoftDeletes;

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table    = 'salesman';

	protected $fillable = ['name', 'email', 'commission'];

	protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

	protected $dates    = ['created_at', 'updated_at', 'deleted_at'];

	public static $rules = [
		'create' => [
			'name'  => 'required|min:5',
			'email' => 'required|email|unique:salesman,email'
		]
	];

	public static function rules($action, $id=false, $merge=[])
	{
		$rules = Salesman::$rules[$action];

		if ($id) {
			foreach ($rules as &$rule) {
				$rule = str_replace(':id', $id, $rule);
			}
		}
		return array_merge( $rules, $merge );
	}

	public function sales() {
		return $this->hasMany('App\Sale', 'salesman_id', 'id');
	}

	public function getAllSalesman($per_page = 0) {
		$query = Salesman::orderBy('name');

		if ($per_page > 0) {
			$result = $query->paginate($per_page);
		} else {
			$result = $query->get();
		}

		return $result;
	}

}
