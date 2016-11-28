<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModel;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends MyController
{
    /**
     * @var JWTAuth
     */
    private $jwt;

    public function __construct(JWTAuth $jwt)
    {
        parent::__construct();
        $this->jwt = $jwt;
    }

    /**
     * @param Request $request
     * Test login
     * http://baseapi.dev/auth/login?email=admin1@gmail.com&password=123123
     */
    public function loginAction(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);
        if($validate->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validate->errors());
        }
        try {
            $token = $this->jwt->attempt($request->only('email', 'password'));
            if ($token) {
                return $this->response->array(['token' => $token]);
            } else {
                return $this->response->error('email or password invalid', 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->response->errorUnauthorized('Unauthorized: token_expired');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->response->errorUnauthorized('Unauthorized: token_invalid');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->response->errorUnauthorized('Unauthorized: token_absent');
        }
    }

    public function detail($id) {
        try {
            $user = UserModel::findOrFail($id);
            return $this->responseItem($user, new UserTransformer());
        } catch (\Exception $ex) {
            return $this->showException($ex);
        }
    }

}
