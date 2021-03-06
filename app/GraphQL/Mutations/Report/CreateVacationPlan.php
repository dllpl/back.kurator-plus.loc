<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 01.02.2020
 * Time: 19:16
 */

namespace App\GraphQL\Mutations\Report;

use App\Exceptions\ModelNotFoundException;
use App\GraphQL\Mutations\CreateMutation;
use App\Models\Core\LearningStream;
use App\Models\Report\VacationPlan;

class CreateVacationPlan extends CreateMutation
{
    protected $modelClass = VacationPlan::class;

    /**
     * @param \App\GraphQL\Mutations\MutationData $data
     * @return \App\GraphQL\Mutations\Mutation
     * @throws ModelNotFoundException
     */
    protected function transformAttributes($data)
    {
        $streamId = LearningStream::find($this->learningStreamId);
        if (!$streamId) {
            throw new ModelNotFoundException('Stream not found');
        }

        $data->organization_id = $streamId->organization->id;
        $data->user_id = auth()->user()->id;

        return parent::transformAttributes($data); // TODO: Change the autogenerated stub
    }
}
