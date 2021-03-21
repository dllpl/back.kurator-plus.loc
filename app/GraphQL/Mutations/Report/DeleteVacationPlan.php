<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 01.02.2020
 * Time: 19:16
 */

namespace App\GraphQL\Mutations\Report;

use App\GraphQL\Mutations\DeleteMutation;
use App\Models\Report\VacationPlan;

class DeleteVacationPlan extends DeleteMutation
{
    protected $modelClass = VacationPlan::class;
}
