<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.08.2019
 * Time: 14:26
 */

namespace App\Passport\Bridge;

use App\Passport\RefreshToken;
use Laravel\Passport\Bridge\RefreshTokenRepository as LaravelRefreshTokenRepository;
use Laravel\Passport\Events\RefreshTokenCreated;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

class RefreshTokenRepository extends LaravelRefreshTokenRepository
{

    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        RefreshToken::insert([
                'id' => $id = $refreshTokenEntity->getIdentifier(),
                'access_token_id' => $accessTokenId = $refreshTokenEntity->getAccessToken()->getIdentifier(),
                'revoked' => false,
                'expires_at' => $refreshTokenEntity->getExpiryDateTime(),
            ]);

        $this->events->dispatch(new RefreshTokenCreated($id, $accessTokenId));
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId): void
    {
        RefreshToken::where('id', $tokenId)->update(['revoked' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId): bool
    {
        $refreshToken = RefreshToken::where('id', $tokenId)->first();

        return $refreshToken === null || $refreshToken->revoked;
    }
}
