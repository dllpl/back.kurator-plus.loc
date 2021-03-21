<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 13:49
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\UpdateMutation;
use App\Models\Core\LearningStream;

class UpdateLearningStream extends UpdateMutation
{
    protected $modelClass = LearningStream::class;

    protected $excluded = [
        'organizationId',
    ];
}
