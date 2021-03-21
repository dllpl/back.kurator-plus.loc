<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 13:50
 */

namespace App\GraphQL\Mutations\Core;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\ModelSaveException;
use App\GraphQL\Mutations\DeleteMutation;
use App\Models\Core\LearningStream;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Throwable;

class DeleteLearningStream extends DeleteMutation
{
    protected $modelClass = LearningStream::class;

    /**
     * @return bool|Model
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    protected function handle()
    {
        /** @var LearningStream $learningStream */
        $learningStream = $this->getModel();

        $result = parent::handle();

        foreach ($learningStream->streamStudents as $streamStudent) {
            UnlinkStudentFromStream::mutate([], ['id' => $streamStudent->id]);
        }

        foreach ($learningStream->streamLeaders as $streamLeader) {
            UnlinkLeaderFromStream::mutate([], ['id' => $streamLeader->id]);
        }

        return $result;
    }
}
