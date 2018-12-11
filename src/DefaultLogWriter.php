<?php

namespace Daisanmu\HttpLogger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Daisanmu\HttpLogger\LogRequests;

class DefaultLogWriter implements LogWriter
{
    public function logRequest(Request $request)
    {
        $method = strtoupper($request->getMethod());

        $uri = $request->getPathInfo();

        $bodyAsJson = json_encode($request->except(config('http-logger.except_request')),JSON_UNESCAPED_UNICODE);

        $headerJson = json_encode(array_diff_key($request->header(),array_flip(config('http-logger.except_header'))),JSON_UNESCAPED_UNICODE);

        $files = array_map(function (UploadedFile $file) {
            return $file->getClientOriginalName();
        }, iterator_to_array($request->files));

        $message = "-requestId:{$request->offsetGet('requestId')} -method: {$method} -path: {$uri} -header: {$headerJson} -IP:{$request->getClientIp()} - Body: {$bodyAsJson} - Files: ".implode(', ', $files);

        (new LogRequests())->outputLine($message);
    }
}
