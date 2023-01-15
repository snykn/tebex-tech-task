<?php

namespace App\Http\Helpers\Servers;

use GuzzleHttp\Client;
use App\Contracts\ServerLookUp;
use App\Http\Resources\UserResource;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

class XBL implements ServerLookUp
{
	const USER_ENDPOINT = 'https://ident.tebex.io/usernameservices/3/username/';

    /**
     * Function to return the server name.
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'xbl';
    }

    /**
     * Function to return test user details.
     *
     * @return array
     */
    public static function getTestUser(): array
    {
        return [
            'type'     => self::getName(),
            'username' => 'tebex',
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
            'type' => self::getName(),
            'id'   => '2533274884045330',
        ];
    }

    /**
     * Function to return the result of a user query.
     *
     * @param $data
     * @return UserResource
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function lookup($data): UserResource
    {
        $result = json_decode($this->getUser($data)->getBody());

        return new UserResource($result);
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
            $response = $guzzle->get(self::USER_ENDPOINT . $data->username . '?type=username');
        } else if ($data->id) {
            $response = $guzzle->get(self::USER_ENDPOINT . $data->id);
        }

        return $response;
    }
}
