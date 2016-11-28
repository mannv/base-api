<?php

/**
 * Created by Kayac Ha Noi.
 * User: ManNV
 * Date: 11/28/2016
 * Time: 1:54 PM
 */
namespace App\Transformer;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user) {
        $attributes = $user->toArray();
        return $attributes;
    }
}