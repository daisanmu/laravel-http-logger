<?php

return [

    /*
     * The log profile which determines whether a request should be logged.
     * It should implement `LogProfile`.
     */
    'log_profile' => \Spatie\HttpLogger\LogNonGetRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer' => \Spatie\HttpLogger\DefaultLogWriter::class,

    /*
     * Filter out body fields which will never be logged.
     */
    'except_request' => [
        //'password',
        //'password_confirmation',
    ],
    'except_header' => [
        'postman-token',
        'accept',
        'accept-language',
        'accept-encoding',
        'cache-control',
        'content-type',
        'content-length',
        'connection',
        'host',
        'user-agent',
        'origin'
    ],
    
];
