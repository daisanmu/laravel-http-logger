<?php

namespace Daisanmu\HttpLogger\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Daisanmu\HttpLogger\LogWriter;
use Illuminate\Support\Facades\Log;
use Daisanmu\HttpLogger\LogProfile;
use Daisanmu\HttpLogger\LogRequests;

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
        if(in_array($response->getStatusCode(),config('http-logger.send_mail_status',[]))){
            $to = config('http-logger.send_to',[]);
            foreach ($to as $email){
                $subject = config('app.name').'-error';
                Mail::raw($response->exception, function ($m) use ($subject,$email){

                    $m->to($email);

                    $m->subject($subject);
                });
            }

        }
        $message = "-requestId: {$request->offsetGet('requestId')} -response: {$response->getContent()}";

        (new LogRequests())->outputLine($message);

    }



}
