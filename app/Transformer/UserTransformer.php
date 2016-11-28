<?php

/**
 * Created by Kayac Ha Noi.
 * User: ManNV
 * Date: 11/28/2016
 * Time: 1:54 PM
 */
namespace App\Transformer;
use App\Models\UserModel;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(UserModel $user) {
        $attributes = $user->toArray();
        return $attributes;
    }
}