<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Solid\Repositories\AuthRepository;
use App\Solid\Traits\JsonTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use JsonTrait;

    private $data;

    public function __construct(AuthRepository $data)
    {
        $this->data = $data;
    }

    public function register(RegisterRequest $r)
    {
        User::create($r->all());
        return $this->whenDone('Successfully Created');
    }

    public function login(LoginRequest $r)
    {
        return $this->data->login($r->all());
    }
}
