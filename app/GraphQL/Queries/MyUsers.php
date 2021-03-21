<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 11.11.2019
 * Time: 16:13
 */

namespace App\GraphQL\Queries;

use App\Exceptions\GraphqlException;
use App\Models\Core\LearningStream;
use App\Models\Core\Organization;
use App\Models\Core\RelatedOrganization;
use App\Models\Core\RelatedStream;
use App\Models\Core\RelatedUser;
use App\Models\Core\Relationship;
use App\Models\Core\StreamRelatedUser;
use App\Models\Core\StreamStudent;
use App\Models\Core\User;
use DB;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;

class MyUsers extends Query
{
    /**
     * @param array $args
     * @return Builder
     * @throws GraphqlException
     */
    public function call(array $args)
    {
        $user = $this->getModel();
        if (!$user) {
            return $this->forbidden();
        }

        switch ($args['myRelationship']) {
            case Relationship::DIRECTOR:
            case Relationship::SECRETARY:
            case Relationship::DEPUTY_DIRECTOR_ACADEMY:
            case Relationship::DEPUTY_DIRECTOR_EDUCATION:
            case Relationship::DEPUTY_DIRECTOR_METHODOLOGY:
            case Relationship::DEPUTY_DIRECTOR_SUPPLY:
            case Relationship::STREAM_LEADER:
                /** @var Organization $organization */
                $organization = $user->belongsToMany(Organization::class, RelatedOrganization::class)
                    ->wherePivot('relationship_id', $args['myRelationship'])
                    ->wherePivot('organization_id', $args['organizationId'])
                    ->wherePivot('deleted_at', 'is not distinct from', DB::raw('null'))
                    ->first();
                if (!$organization) {
                    return $this->forbidden();
                }

                if (isset($args['learningStreamId'])) {
                    if ($args['myRelationship'] === Relationship::STREAM_LEADER) {
                        $stream = $user->belongsToMany(LearningStream::class, RelatedStream::class)
                            ->wherePivot('relationship_id', Relationship::STREAM_LEADER)
                            ->wherePivot('learning_stream_id', $args['learningStreamId'] ?? null)
                            ->first();
                    }
                    else {
                        $stream = $organization->learningStreams()->find($args['learningStreamId']);
                    }
                    if (!$stream) {
                        return $this->forbidden();
                    }

                    $users = $stream->belongsToMany(
                        User::class,
                        StreamRelatedUser::class
                    );
                }
                else {
                    $users = $organization->belongsToMany(
                        User::class,
                        RelatedUser::class
                    );
                }

                if (isset($args['usersRelationships'])) {
                    $users->wherePivotIn('relationship_id', $args['usersRelationships']);
                }

                break;
            default:
                return $this->forbidden();
        }

        $users->wherePivot('deleted_at', 'is not distinct from', DB::raw('null'));

        $fio = $args['fio'] ?? null;
        if ($fio !== null) {
            $users->where(function (EloquentBuilder $builder) use ($fio) {
                foreach (['name', 'surname', 'patronymic'] as $field) {
                    $builder->orWhere($field, '~~*', "$fio%");
                }
            });
        }

        return $users->select(DB::raw('DISTINCT ON (users.id) *'));
    }

    /**
     * @throws GraphqlException
     */
    public function forbidden(): Builder
    {
        throw new GraphqlException('Forbidden');
    }

    public function getModel()
    {
        return parent::getModel() ?? auth()->user();
    }
}
