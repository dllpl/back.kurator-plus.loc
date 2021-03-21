<?php
/**
 * Created by PhpStorm.
 * User: V.A.I
 * Date: 04.09.2019
 * Time: 19:40
 */

namespace App\GraphQL\Mutations\Core;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\ModelSaveException;
use App\GraphQL\Mutations\DeleteMutation;
use App\Models\Core\Organization;
use Illuminate\Validation\ValidationException;
use Throwable;

class DeleteOrganization extends DeleteMutation
{
    protected $modelClass = Organization::class;

    /**
     * @return bool
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    protected function handle()
    {
        /** @var Organization $organization */
        $organization = $this->getModel();

        $result = parent::handle();

        foreach ($organization->relatedUsers as $relatedUser) {
            UnlinkUserFromOrganization::mutate([], ['id' => $relatedUser->id]);
        }

        return $result;
    }
}
