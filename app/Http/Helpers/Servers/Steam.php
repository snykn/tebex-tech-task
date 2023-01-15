<?php

namespace App\Http\Helpers\Servers;

use GuzzleHttp\Client;
use App\Contracts\ServerLookUp;
use App\Http\Resources\UserResource;
use GuzzleHttp\Exception\GuzzleException;

class Steam implements ServerLookUp
{
	const USER_ENDPOINT = 'https://ident.tebex.io/usernameservices/4/username/';

    /**
     * Function to return the server name.
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'steam';
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
            'id'   => '76561198806141009',
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
            'username' => 'test',
        ];
    }

    /**
     * Function to return the result of a user query.
     *
     * @param $data
     * @return UserResource|mixed
     * @throws GuzzleException
     */
    public function lookup($data)
    {
        $result = $this->getUser($data);

        return $data->testing || $data->username
            ? $result
            : new UserResource($result);
    }

    /**
     * Function to query the get user endpoint.
     *
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getUser($data)
    {
        $guzzle = new Client();
        $message = 'Steam only supports IDs';

        if ($data->testing && $data->username) {
            return $message;
        } else if ($data->id) {
            $response = json_decode($guzzle->get(self::USER_ENDPOINT . $data->id)->getBody());
        } else if ($data->username) {
            throw new \Exception($message);
        }

        return $response;
    }
}
