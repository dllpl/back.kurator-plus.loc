<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 17.12.2019
 * Time: 10:46
 */

namespace App\GraphQL\Mutations\Core;

use Hash;

trait TransformUser
{
    protected function transformInn($data): self
    {
        if (isset($data->inn)) {
            $data->inn = preg_replace('~\D~', '', $data->inn) ?: null;
        }

        return $this;
    }

    protected function transformPassword($data): self
    {
        if (isset($data->password)) {
            $data->password = Hash::make($data->password);
        }

        return $this;
    }
}
