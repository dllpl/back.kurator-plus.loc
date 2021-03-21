<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 13.11.2019
 * Time: 0:31
 */

namespace App\GraphQL\Mutations\Core;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\ModelSaveException;
use App\GraphQL\Mutations\DeleteManyMutation;
use App\Models\Core\Relationship;
use App\Models\Core\StreamRelatedUser;
use Illuminate\Validation\ValidationException;
use Throwable;

class MoveStudents extends DeleteManyMutation
{
    protected $modelClass = StreamRelatedUser::class;

    protected $excluded = [
        'targetStreamId',
    ];

    protected $map = [
        'sourceStreamId' => 'learning_stream_id',
        'onlyUsers' => 'user_id',
    ];

    /**
     * @return bool
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    protected function handle()
    {
        $streamUsers = $this->getBuilder()->get();
        if ($streamUsers->isEmpty()) {
            throw new ModelNotFoundException('Students not found');
        }

        foreach ($streamUsers as $streamUser) {
            $input = [
                'learningStreamId' => $this->targetStreamId,
                'userId' => $streamUser->user_id,
                'date' => now(),
                'acting' => $streamUser->acting,
            ];
            if ($streamUser->relationship_id === Relationship::STREAM_LEADER) {
                LinkLeaderToStream::mutate($input);
            }
            else {
                LinkStudentToStream::mutate($input);
            }
        }

        return parent::handle();
    }
}
