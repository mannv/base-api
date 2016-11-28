<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\UserModel;

class ExampleController extends MyController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index() {
        $values = array();
        for($i = 0; $i < 5; $i++) {
            $values[] = array(
                'name1' => 'Admin ' . $i,
                'email' => 'admin'.$i.'@gmail.com',
                'password' => \Hash::make('123123')
            );
        }
        $result = UserModel::insertMultiRecord($values);
        echo '<pre>' .print_r($result, true). '</pre>';
    }
    //
}
