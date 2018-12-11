<?php

namespace Daisanmu\HttpLogger;

use Illuminate\Http\Request;

interface LogWriter
{
    public function logRequest(Request $request);
}
