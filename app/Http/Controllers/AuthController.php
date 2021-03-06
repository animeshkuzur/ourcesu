<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;

class AuthController extends Controller
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

    public function login(){
        if (\Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function loginvalidate(Request $request){
        $count = 0;
        $cont_acc = "";
        $this->validate($request, User::$login_validation_rules);
        $data = $request->only('email','password');
        $remember = $request->only('remember');
        if(!empty($remember))
            $flag = true;
        else
            $flag = false;
        if(\Auth::attempt($data, $flag)){
            $id=\Auth::user()->id;
            $user_data = \DB::table('users_details')->where('users_id',$id)->get();
            foreach ($user_data as $user_dat) {
                $count=$count+1;
                $cont_acc = $user_dat->CONTRACT_ACC;
            }
            if($count>1){
               return redirect()->route('select-acc'); 
            }
            else{
                \DB::table('users')->where('id',$id)->update(['CONT_ACC' => $cont_acc]);
                return redirect()->route('dashboard');
            }
        }
        else
            return back()->withInput()->withErrors(['email' => 'Username or password is invalid']);
    }

    public function logout(){
        \Auth::logout();
        return redirect()->route('login');
    }

    public function forgot(){
        return view('auth.forgot');
    }
}

