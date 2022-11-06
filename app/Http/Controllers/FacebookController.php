<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    function redirectToProvider(){
        return Socialite::driver('facebook')->redirect();
    }

    function handleToProviderCallback(){
        $user =  Socialite::driver('facebook')->user();

        if(CustomerLogin::where('email', $user->getEmail())->exists()){
            if(Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(),'password'=>'abc@123'])){
              return redirect('https://tanvirhasantonmoy.com/');
            }
        }
        else{
            CustomerLogin::insert([
                'name'=>$user->getName(),
                'email'=>$user->getEmail() ?? "test@gmail.com",
                'password'=>bcrypt('abc@123'),
                'email_verified_at'=>Carbon::now(),
                'created_at'=>Carbon::now(),
            ]);
            if(Auth::guard('customerlogin')->attempt(['email'=>$user->getEmail() ?? "test@gmail.com",'password'=>'abc@123'])){
                return redirect('https://tanvirhasantonmoy.com/');
              }
        }
    }
}
