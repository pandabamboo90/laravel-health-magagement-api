<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return the value of per_page param if it's existed, otherwise use the default value is 10
     *
     * @return numeric
     */
    protected function perPageParam(Request $request)
    {
        return $request->has('per_page') ? $request->input('per_page') : 10;
    }
}
