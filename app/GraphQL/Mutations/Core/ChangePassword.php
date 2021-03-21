<?php
/**
 * Created by PhpStorm.
 * User: V.A.I
 * Date: 03.09.2019
 * Time: 17:45
 */

namespace App\GraphQL\Mutations\Core;

use App\Exceptions\PasswordMismatchException;
use App\GraphQL\Mutations\UpdateUserMutation;
use Hash;
use Illuminate\Validation\ValidationException;

class ChangePassword extends UpdateUserMutation
{
    use TransformUser;

    /**
     * @return PasswordMismatchException
     */
    public function getModelNotFoundException()
    {
        return new PasswordMismatchException('Password not changed', 'Invalid current password');
    }

    /**
     * @param $data
     * @return self
     * @throws PasswordMismatchException
     * @throws ValidationException
     */
    protected function checkInput($data)
    {
        parent::checkInput($data);

        $user = $this->getModel();

        if (!Hash::check($this->currentPassword, $user->getAuthPassword())) {
            throw $this->getModelNotFoundException();
        }

        return $this;
    }

    protected function transformAttributes($data)
    {
        parent::transformAttributes($data);

        $this->transformPassword($data);

        return $this;
    }
}
