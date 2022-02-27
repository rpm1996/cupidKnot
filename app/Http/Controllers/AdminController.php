<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use App\Models\User;


class AdminController extends Controller
{
    public function admin(){
        return view('admin.login');
    }

    public function adminlogin(Request $request){
        if($request->uname && $request->psw){
            $checkLogin = DB::table('admin')->where(['email'=>$request->uname])->first();
            if(Hash::check($request->psw, $checkLogin->password)){
                session()->forget('admin_login');
                session()->put('admin_login', $request->uname);
                return redirect('all-users');
            }
            else{
                return redirect('admin')->with('success', 'Invalid Credentials');
            }
        }
    }

    public function allUsers(Request $request){
        
        $getData = User::all(); 
        if($request->gender){
            $getData = $getData->where('gender', $request->gender);
        }
        if($request->familytype){
            $getData = $getData->where('family_type', $request->familytype);
        }
        if($request->manglik){
            $getData = $getData->where('manglik', $request->manglik);
        }
        if($request->incomeRange){
            $range = $request->incomeRange; 
            $range = explode('-', $request->incomeRange);
            $getData = $getData->whereBetween('annual_income', [$range[0], $range[1]]);
        }

        return view("admin.all-user", compact('getData'));
    }

    public function adminLogout(){
        session()->forget('admin_login');
        return redirect('admin');
    }
}
