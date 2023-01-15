<?php

namespace Tests\Feature;

use App\Http\Helpers\Servers\Minecraft;
use App\Http\Helpers\Servers\Steam;
use App\Http\Helpers\Servers\XBL;
use Tests\TestCase;

class LookUpTest extends TestCase
{
    const TESTING_FLAG = [
        'testing' => true,
    ];

    /**
     * Test to ensure that the endpoint returns a successful response.
     *
     * @return void
     */
    public function testMinecraftUserLookupWithId()
    {
        $parameters = Minecraft::getTestUser();
        $parameters += self::TESTING_FLAG;
        $response = $this->get(route('lookup.users', $parameters));

        $response->assertStatus(200);
    }

    /**
     * Test to ensure that the endpoint returns a successful response.
     *
     * @return void
     */
    public function testMinecraftUserLookupWithUsername()
    {
        $parameters = Minecraft::getTestUserAlt();
        $parameters += self::TESTING_FLAG;
        $response = $this->get(route('lookup.users', $parameters));

        $response->assertStatus(200);
    }

    /**
     * Test to ensure that the meta data returned is not empty.
     *
     * @return void
     */
    public function testSteamUserLookupWithId()
    {
        $parameters = Steam::getTestUser();
        $parameters += self::TESTING_FLAG;
        $response = $this->get(route('lookup.users', $parameters));

        $response->assertStatus(200);
        $this->assertNotEmpty($response->getData()->data->meta);
    }

    /**
     * Test to ensure that when querying the endpoint with anything other than an ID, an error string is provided.
     *
     * @return void
     */
    public function testSteamUserLookupWithUsername()
    {
        $parameters = Steam::getTestUserAlt();
        $parameters += self::TESTING_FLAG;
        $response = $this->get(route('lookup.users', $parameters));

        $this->assertIsString($response->getContent());
    }

    /**
     * Test to ensure that the endpoint returns a data object.
     *
     * @return void
     */
    public function testXblUserLookupWithId()
    {
        $parameters = XBL::getTestUserAlt();
        $response = $this->get(route('lookup.users', $parameters));

        $this->assertIsObject($response->getData());
    }

    /**
     * Test to ensure that the endpoint contains the data object.
     *
     * @return void
     */
    public function testXblUserLookupWithUsername()
    {
        $parameters = XBL::getTestUser();
        $response = $this->get(route('lookup.users', $parameters));

        $this->assertArrayHasKey('data', $response);
    }
}
