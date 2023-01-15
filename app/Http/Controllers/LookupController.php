<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\UserLookUpService;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class LookupController
 *
 * @package App\Http\Controllers
 */
class LookupController extends ResponseController
{
    const LOOKUP_ERROR_MESSAGE   = 'Lookup failed';
    const LOOKUP_SUCCESS_MESSAGE = 'Lookup successful';

    /**
     * API function used to return the results from the user lookup service.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function lookup(Request $request)
    {
        try {
            return $this->successResponse(
                self::LOOKUP_SUCCESS_MESSAGE, (new UserLookUpService($request))->lookup()
            );
        } catch(\Exception $e) {
            return $this->errorResponse(
                self::LOOKUP_ERROR_MESSAGE . ' ' . $e->getMessage()
            );
        }
    }
}
