<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'type', 'message'
    ];

    public static function saveLog($type, $message) {
        return self::create([
            'type' => $type,
            'message' => $message
        ]);
    }
}
