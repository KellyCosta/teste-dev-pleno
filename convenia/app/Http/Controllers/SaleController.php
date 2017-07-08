<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Salesman;
use Validator;
use Config;

class SaleController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $content   = json_decode(json_encode($request->all()), true);
            $validator = Validator::make($request->all(), Sale::rules('create'));

            if ($validator->fails()) {
                $result['message'] = $validator->messages()->all();
                $result['status']  = 'error';

                return response()->json($result, 422);
            }

            $input = [
                "salesman_id"     => $content{"salesman_id"},
                "sale_value"      => $content{"sale_value"},
                "sale_commission" => $this->calculateCommission($content{"sale_value"}),
                "sale_date"       => date('Y-m-d')
            ];

            $sale  = Sale::create($input);
            $dados = [
                "id"              => $sale->id,
                "name"            => $sale->salesman->name,
                "email"           => $sale->salesman->email,
                "sale_value"      => $sale->sale_value,
                "sale_commission" => $sale->sale_commission,
                "sale_date"       => $sale->sale_date
            ];

            return response()->json(['dados' => $dados]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    function calculateCommission($saleValue){
        return ($saleValue * Config::get("constants.SALESMAN_COMMISSION"));
    }
}
