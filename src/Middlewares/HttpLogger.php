<?php

namespace Spatie\HttpLogger\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Spatie\HttpLogger\LogWriter;
use Illuminate\Support\Facades\Log;
use Spatie\HttpLogger\LogProfile;
use Spatie\HttpLogger\LogRequests;

class HttpLogger
{
    protected $logProfile;
    protected $logWriter;

    public function __construct(LogProfile $logProfile, LogWriter $logWriter)
    {
        $this->logProfile = $logProfile;
        $this->logWriter = $logWriter;
    }

    public function handle(Request $request, Closure $next)
    {
        $request->offsetSet('requestId', time().uniqid());
        if ($this->logProfile->shouldLogRequest($request)) {
            $this->logWriter->logRequest($request);
        }

        return $next($request);
    }

    public function  terminate($request, $response)
    {
        $message = "-requestId: {$request->offsetGet('requestId')} -response: {$response->getContent()}";
        (new LogRequests())->outputLine($message);
    }



}
