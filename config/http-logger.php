<?php

return [

    /*
     * The log profile which determines whether a request should be logged.
     * It should implement `LogProfile`.
     */
    'log_profile' => \Daisanmu\HttpLogger\LogRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer' => \Daisanmu\HttpLogger\DefaultLogWriter::class,

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
    'send_mail_status' => [
        '500'
    ],
    'send_to' => [

    ]
    
];
