<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 21.09.2019
 * Time: 18:24
 */

namespace App\GraphQL\Mutations\Core;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\ModelSaveException;
use App\GraphQL\Mutations\DeleteMutation;
use App\Models\Core\User;
use Illuminate\Validation\ValidationException;
use Throwable;

class DeleteUser extends DeleteMutation
{
    protected $modelClass = User::class;

    /**
     * @return bool
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    protected function handle()
    {
        /** @var User $user */
        $user = $this->getModel();

        $result = parent::handle();

        foreach ($user->relatedOrganizations as $relatedOrganization) {
            UnlinkUserFromOrganization::mutate([], ['id' => $relatedOrganization->id]);
        }

        return $result;
    }
}
