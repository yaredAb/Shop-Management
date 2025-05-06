<?php

use App\Models\SystemLog;

function log_to_db($type, $message) {
    SystemLog::create([
        'type' => $type,
        'message' => $message
    ]);
}