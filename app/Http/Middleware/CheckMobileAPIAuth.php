<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\HelperFunctions;
use App\Models\Company;

class CheckMobileAPIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $helperFunction = new HelperFunctions();
        $companyId = $helperFunction->unhashId($request->token);
        $company = Company::find($companyId);
        if ($company) {
            if (!(($company->id == $companyId) && ($company->token == $request->token))) {
                $response_message =  array('success' => false, 'message' => "Invalid token", 'data' => []);
                return response()->json($response_message);
            }
        } else {
            $response_message =  array('success' => false, 'message' => "Invalid token", 'data' => []);
            return response()->json($response_message);
        }
        
        return $next($request);
    }
}
