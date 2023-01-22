<?php

namespace App\Http\Requests;

use App\Models\User;

trait HasUserAccount {
    public function validUserAccount($validator)
    {
        if(request()->has('username') && request('username') != ""){
            $username = request('username');
            $password = request('password');

            $user = User::whereUsername($username);
            if(request('id')){
                $user->where('id', '<>', request('id'));
            }
            $user = $user->first();
            if($user){
                $validator->errors()->add("username", "The username field is already taken.");
            }
        }
    }
}