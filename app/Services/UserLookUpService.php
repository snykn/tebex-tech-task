<?php

namespace App\Services;

use App\Http\Helpers\Servers\XBL;
use App\Http\Helpers\Servers\Steam;
use App\Http\Helpers\Servers\Minecraft;
use App\Exceptions\ServerNotFoundException;

class UserLookUpService
{
    private $data = null;

    public function __construct($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Function to initialise the retrieval of user lookup data.
     *
     * @return \App\Http\Resources\UserResource|string|null
     * @throws ServerNotFoundException|\GuzzleHttp\Exception\GuzzleException
     */
    public function lookup()
    {
        switch ($this->data->type) {
            case Minecraft::getName():
                return (new Minecraft())->lookup($this->data);
            case Steam::getName():
                return (new Steam())->lookup($this->data);
            case XBL::getName():
                return (new XBL())->lookup($this->data);
            default:
                throw new ServerNotFoundException(ServerNotFoundException::DEFAULT_MESSAGE);
        }
    }
}
