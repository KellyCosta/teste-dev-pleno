<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salesman;
use Validator;
use Config;

class SalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $salesman = new Salesman;
            $salesman = $salesman->getAllSalesman();

            return response()->json(["dados" => $salesman], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

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

            $validator = Validator::make($request->all(), Salesman::rules('create'));

            if ($validator->fails()) {
                $result['message'] = $validator->messages()->all();
                $result['status']  = 'error';

                return response()->json($result, 422);
            }

            $input = [
                "name"       => $content{"name"},
                "email"      => $content{"email"},
                "commission" => Config::get("constants.SALESMAN_COMMISSION")
            ];

            $salesman = Salesman::create($input);

            return response()->json([$salesman]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function getSaleBySalesmanID(Request $request, $salesman_id){
        try{
            $salesman = Salesman::find($salesman_id);
            $salesman->load('sales');

            return response()->json(["dados" => $salesman], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

}
