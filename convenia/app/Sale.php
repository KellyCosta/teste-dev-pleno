<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Config;
use Salesman;

class Sale extends Model
{
    use SoftDeletes;

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table    = 'sales';

	protected $fillable = ['salesman_id', 'sale_value', 'sale_commission', 'sale_date'];

	protected $hidden   = ['salesman_id', 'created_at', 'updated_at', 'deleted_at'];

	protected $dates    = ['created_at', 'updated_at', 'deleted_at'];

	public static $rules = [
		'create' => [
			'salesman_id' => 'required',
			'sale_value'  => 'required'
		]
	];

	public static function rules($action, $id=false, $merge=[])
	{
		$rules = Sale::$rules[$action];

		if ($id) {
			foreach ($rules as &$rule) {
				$rule = str_replace(':id', $id, $rule);
			}
		}
		return array_merge( $rules, $merge );
	}

	public function salesman() {
		return $this->belongsTo('App\Salesman', 'salesman_id');
	}

	public function getSaleBySalesmanId($salesman_id, $per_page = 0) {
		$query = Sale::with(['salesman' => function ($query) {
			$query->select('name','email');
		}])
		->where('salesman_id', $salesman_id)
		->orderBy('sale_date', 'desc');

		if ($per_page > 0) {
			$result = $query->paginate($per_page);
		} else {
			$result = $query->get();
		}

		return $result;
	}
}
