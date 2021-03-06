<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiemobilereceipt(){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['errorInfo' => 'user_not_found'], 404);
            }
            
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['errorInfo' => 'token_expired'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['errorInfo' => 'token_invalid'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errorInfo' => 'token_absent'], $e->getStatusCode());
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json(['errorInfo'=> $ex]);
        }
        //$data = $request->only('date');
        $CONTRACT_ACC = $user->CONT_ACC;
        $data = \DB::table('VW_SPOT_MR_DETAILS')->where(['CONTRACT_ACC'=> $CONTRACT_ACC])->orderBy('BillMonth', 'desc')->get();
        return response()->json(['Info' => $data]);
    }

    public function emobilereceipt(Request $request){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['errorInfo' => 'user_not_found'], 404);
            }
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['errorInfo' => 'token_expired'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['errorInfo' => 'token_invalid'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errorInfo' => 'token_absent'], $e->getStatusCode());
        }

        $user_cont_acc = $user->CONT_ACC;
        $billmonth = $request->only('BillMonth');
        $stl_conn = \DB::connection('sqlsrv_STL');
        $data = \DB::table('VW_SPOT_MR_DETAILS')->where(['CONTRACT_ACC'=> $user_cont_acc])->where('BillMonth', $billmonth)->get();
        foreach ($data as $dat) {
        }
        $path = base_path('temp/emobilereceipt/'.$user_cont_acc.'.pdf');
        $pdf = \PDF::loadView('pdf-layout.e-mobile-receipt', ['dat'=>$dat]);
        $pdf->save($path,$overwrite = true);
        return response()->json(['Info' => $data,'Download' => $path]);
    }

    public function apimoneyreceipt(){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['errorInfo' => 'user_not_found'], 404);
            }
            
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['errorInfo' => 'token_expired'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['errorInfo' => 'token_invalid'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errorInfo' => 'token_absent'], $e->getStatusCode());
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json(['errorInfo'=> $ex]);
        }

        
    }

    public function getservicereq(){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['errorInfo' => 'user_not_found'], 404);
            }
            
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['errorInfo' => 'token_expired'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['errorInfo' => 'token_invalid'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errorInfo' => 'token_absent'], $e->getStatusCode());
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json(['errorInfo'=> $e]);
        }
        $CONS_ACC=NULL;
        $CONTRACT_ACC = $user->CONT_ACC;
        $stl_conn = \DB::connection('sqlsrv_STL');
        $USER_DATA = $stl_conn->table('BILLING_OUTPUT_'.date('Y'))->where('CONTRACT_ACC', $CONTRACT_ACC)->limit(1)->get();
        foreach ($USER_DATA as $dat) {
            $CONS_ACC = $dat->CONS_ACC;
        }
        $service_conn = \DB::connection('sqlsrv_SERVICE');
        $data=$service_conn->table('CC_REQ_MAS')->join('CC_SERVICE_TYPE_MAS','CC_REQ_MAS.SERVICE_TYPE_ID','=','CC_SERVICE_TYPE_MAS.SERVICE_TYPE_ID')->join('CC_SERVICE_TYPE_GROUP_MAS','CC_SERVICE_TYPE_GROUP_MAS.SERVICE_TYPE_GROUP_ID','=','CC_SERVICE_TYPE_MAS.SERVICE_TYPE_GROUP_ID')->join('CC_REQ_STAT_MAS','CC_REQ_MAS.REQ_STATUS_ID','=','CC_REQ_STAT_MAS.REQ_STATUS_ID')->where('CONS_ACC',$CONS_ACC)->get();
        return response()->json(['Info' => $data]);
    }

    public function servicereq(Request $request){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['errorInfo' => 'user_not_found'], 404);
            }
            
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['errorInfo' => 'token_expired'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['errorInfo' => 'token_invalid'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errorInfo' => 'token_absent'], $e->getStatusCode());
        }
        catch(\Illuminate\Database\QueryException $e){
            return response()->json(['errorInfo'=> $e]);
        }
        $CONS_ACC=NULL;
        $CONTRACT_ACC = $user->CONT_ACC;
        $req_no = $request->only('ReqNo');
        $stl_conn = \DB::connection('sqlsrv_STL');
        $USER_DATA = $stl_conn->table('BILLING_OUTPUT_'.date('Y'))->where('CONTRACT_ACC', $CONTRACT_ACC)->limit(1)->get();
        foreach ($USER_DATA as $dat) {
            $CONS_ACC = $dat->CONS_ACC;
        }
        $service_conn = \DB::connection('sqlsrv_SERVICE');
        $data=$service_conn->table('CC_REQ_MAS')->join('CC_SERVICE_TYPE_MAS','CC_REQ_MAS.SERVICE_TYPE_ID','=','CC_SERVICE_TYPE_MAS.SERVICE_TYPE_ID')->join('CC_SERVICE_TYPE_GROUP_MAS','CC_SERVICE_TYPE_GROUP_MAS.SERVICE_TYPE_GROUP_ID','=','CC_SERVICE_TYPE_MAS.SERVICE_TYPE_GROUP_ID')->join('CC_REQ_STAT_MAS','CC_REQ_MAS.REQ_STATUS_ID','=','CC_REQ_STAT_MAS.REQ_STATUS_ID')->where('CONS_ACC',$CONS_ACC)->where('REQ_NO',$req_no)->get();

        foreach ($data as $dat) {
        }
        $path = base_path('temp/servicereq/'.$CONTRACT_ACC.'.pdf');
        $pdf = \PDF::loadView('pdf-layout.service-request', ['dat'=>$dat]);
        $pdf->save($path,$overwrite = true);
        return response()->json(['Info' => $data,'Download' => $path]);
    }

    public function spotbill(Request $request){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['errorInfo' => 'user_not_found'], 404);
            }
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['errorInfo' => 'token_expired'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['errorInfo' => 'token_invalid'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errorInfo' => 'token_absent'], $e->getStatusCode());
        }

        $user_cont_acc = $user->CONT_ACC;
        $billmonth = $request->only('BillMonth');
        $stl_conn = \DB::connection('sqlsrv_STL');
        $data = $stl_conn->table('BILLING_OUTPUT_'.date('Y'))->where('CONTRACT_ACC', $user_cont_acc)->where('BillMonth',$billmonth)->get();
        foreach ($data as $dat) {
        }
        $path = base_path('temp/spotbills/'.$user_cont_acc.'.pdf');
        $pdf = \PDF::loadView('pdf-layout.spot-bill', ['dat'=>$dat]);
        $pdf->save($path,$overwrite = true);
        return response()->json(['Info' => $data,'Download' => $path]);
    }

    public function sapbill(Request $request){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['errorInfo' => 'user_not_found'], 404);
            }
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['errorInfo' => 'token_expired'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['errorInfo' => 'token_invalid'], $e->getStatusCode());
        } 
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['errorInfo' => 'token_absent'], $e->getStatusCode());
        }

        $user_cont_acc = $user->CONT_ACC;
        $billmonth = $request->only('BillMonth');
        $stl_conn = \DB::connection('sqlsrv_SAP');
        $data = $stl_conn->table('BILLING_DATA')->where('CONTRACT_ACC', $user_cont_acc)->where('BILL_MONTH',$billmonth)->get();
        foreach ($data as $dat) {
        }
        $path = base_path('temp/sapbills/'.$user_cont_acc.'.pdf');
        $pdf = \PDF::loadView('pdf-layout.sap-bill', ['dat'=>$dat]);
        $pdf->save($path,$overwrite = true);
        return response()->json(['Info' => $data,'BillMonth'=>$billmonth,'Download' => $path]);
    }

}
