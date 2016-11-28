<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\UserModel;
use App\Transformer\UserTransformer;

class ExampleController extends MyController
{

    public function index() {
//        $values = array();
//        for($i = 0; $i < 5; $i++) {
//            $values[] = array(
//                'name1' => 'Admin ' . $i,
//                'email' => 'admin'.$i.'@gmail.com',
//                'password' => \Hash::make('123123')
//            );
//        }
//        $result = UserModel::insertMultiRecord($values);
//        echo '<pre>' .print_r($result, true). '</pre>';

//        $result = UserModel::paginate(2);
//        return $this->responsePaginator($result, new UserTransformer());
        $result = UserModel::all();
        return $this->responseCollection($result, new UserTransformer());
    }
    //
}
