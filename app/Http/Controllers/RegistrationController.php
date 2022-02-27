<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class RegistrationController extends Controller
{
    public function register(){
        $action = "Add";
        return view('register', compact('action'));
    }

    public function profile(){
        $action = "edit";
        $getUser = User::findOrFail(auth()->user()->id);
        return view('customer.profile', compact('action','getUser'));
    }

    public function profileStore(request $request){

        if($request->formType=="Add"){
            $data = request()->validate([
                'first_name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            ], [
                'email.unique' => 'This email already exist.',
                ]
            );
        }

        $data['last_name'] = $request->last_name;
        $data['password'] = Hash::make($request->password);
        $data['dob'] = $request->dob;
        $data['gender'] = $request->gender;
        $data['annual_income'] = $request->annual_income;
        $data['occupation'] = $request->occupation;
        $data['family_type'] = $request->family_type;
        $data['manglik'] = $request->manglik;
        $data['partner_expected_income'] = $request->partner_expected_income;
        $data['partner_occupation'] = $request->partner_occupation ? json_encode($request->partner_occupation) : NULL;
        $data['partner_family_type'] = $request->partner_family_type ? json_encode($request->partner_family_type) : NULL;
        $data['partner_manglik'] = $request->partner_manglik;
        $data['profile_status'] = 1;

        if($request->formType=="Add"){
            $data['created_at'] = date('Y-m-d h:i:s');
            $data['updated_at'] = date('Y-m-d h:i:s');
            DB::table('users')->insert($data);
            return redirect('login')->with("message","successfully Registerd !!");
        }else{
            $data['updated_at'] = date('Y-m-d h:i:s');
            DB::table('users')->where('id', auth()->user()->id)->update($data);
            return redirect('home')->with("message","Successfully Updated !!");
        }
        
    }


    public function matchedProfile(){
        if(auth()->user()->profile_status==0)
            return redirect('profile')->with("success","Please update profile first");
        $gender = "Male";
        if(auth()->user()->gender=="Male"){
            $gender = "Female";
        }
        $getData = User::all()->where('gender', $gender);
        $matchData = [];
        $count = 0;
        foreach($getData as $md){
            $matchData[$count]['name'] = $md->firstName.' '.$md->last_name;
            $matchData[$count]['email'] = $md->email;

            if($md->occupation==auth()->user()->occupation){
                $matchData[$count]['occupation'] = $md->occupation; 
            }
            if($md->family_type==auth()->user()->family_type){
                $matchData[$count]['family_type'] = $md->family_type; 
            }
            if($md->manglik==auth()->user()->manglik){
                $matchData[$count]['manglik'] = $md->manglik; 
            }

            //partner preferance
            if($md->partner_expected_income){
                $mdRange = explode(' - ', $md->partner_expected_income);
                $uRange = explode(' - ', auth()->user()->partner_expected_income);

                if(($uRange[0] >= $mdRange[0] && $uRange[1] <= $mdRange[1])){
                    $matchData[$count]['partner_expected_income'] = $md->partner_expected_income;
                } 
            }

            if($md->partner_occupation){
                $poVal = [];
                $getPo = json_decode($md->partner_occupation, true);
                if(auth()->user()->partner_occupation){
                    $po = json_decode(auth()->user()->partner_occupation, true);
                    foreach ($po as $key => $value) {
                        if(in_array($value, $getPo)){
                            $poVal[] = $value;
                        }
                    }
                } 
                $poVal = implode(', ', $poVal);
                if($poVal){
                    $matchData[$count]['partner_occupation'] = $poVal;
                }
            }

            if($md->partner_family_type){
                $pftVal = [];
                $getPft = json_decode($md->partner_family_type, true);
                if(auth()->user()->partner_occupation){
                    $pft = json_decode(auth()->user()->partner_family_type, true);
                    foreach ($pft as $key => $value) {
                        if(in_array($value, $getPft)){
                            $pftVal[] = $value;
                        }
                    }
                }
                $pftVal = implode(', ', $pftVal);
                if($pftVal){
                    $matchData[$count]['partner_family_type'] = $pftVal;
                }
            }

            if($md->partner_manglik==auth()->user()->partner_manglik){
                $matchData[$count]['partner_manglik'] = $md->partner_manglik;
            }

            $count++;
        }

        $collection = collect($matchData);
        $sorted = $collection->sortDesc();
        $matchData = $sorted->values()->all();
        return view('customer.match-profile', compact('matchData'));
    }
}
