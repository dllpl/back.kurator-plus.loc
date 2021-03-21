<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.10.2019
 * Time: 19:17
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\CreateMutation;
use App\Models\Core\LearningStream;

class CreateLearningStream extends CreateMutation
{
    protected $modelClass = LearningStream::class;
}
