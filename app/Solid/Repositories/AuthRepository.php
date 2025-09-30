<?php


namespace App\Solid\Repositories;


use App\Http\Resources\Api\V1\UserResource;
use App\Solid\Traits\JsonTrait;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    use JsonTrait;
    public function login(array $data)
    {
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            $user = Auth::user();
            return $this->whenDone([
                'token' => 'Bearer '.$user->createToken('MyApp')->plainTextToken,
                'user' => new UserResource($user)
            ]);
        }
        else{
            return $this->whenError('Error Try Again Later');
        }
    }
}
