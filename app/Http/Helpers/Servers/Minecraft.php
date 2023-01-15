<?php

namespace App\Http\Helpers\Servers;

use GuzzleHttp\Client;
use App\Contracts\ServerLookUp;
use App\Http\Resources\UserResource;
use \Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

class Minecraft implements ServerLookUp
{
	const USER_ENDPOINT     = 'https://api.mojang.com/users/profiles/minecraft/';
	const USER_ENDPOINT_ALT = 'https://sessionserver.mojang.com/session/minecraft/profile/';
	const AVATAR_ENDPOINT   = 'https://crafatar.com/avatars/';

    /**
     * Function to return the server name.
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'minecraft';
    }

    /**
     * Function to return test user details.
     *
     * @return array
     */
    public static function getTestUser(): array
    {
        return [
            'type' => self::getName(),
            'id'   => 'd8d5a9237b2043d8883b1150148d6955',
        ];
    }

    /**
     * Function to return alternative test user details.
     *
     * @return array
     */
    public static function getTestUserAlt(): array
    {
        return [
            'type'     => self::getName(),
            'username' => 'Notch',
        ];
    }

    /**
     * Driver function to return the result of a user lookup query.
     *
     * @param $data
     * @return UserResource|int
     * @throws GuzzleException
     */
    public function lookup($data)
    {
        if ($data->testing) {
            return $this->getUser($data)->getStatusCode();
        }

        $result = json_decode($this->getUser($data)->getBody());

        return (new UserResource($result))->setAvatarEndpoint(self::AVATAR_ENDPOINT);
    }

    /**
     * Function to query the get user endpoint.
     *
     * @throws GuzzleException
     */
    public function getUser($data): ResponseInterface
    {
        $guzzle = new Client();

        if ($data->username) {
            $response = $guzzle->get(self::USER_ENDPOINT . $data->username);
        } else if ($data->id) {
            $response = $guzzle->get(self::USER_ENDPOINT_ALT . $data->id);
        }

        return $response;
    }
}
