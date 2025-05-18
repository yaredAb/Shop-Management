<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Throwable;

class Setting extends Model
{
    protected $fillable = ['meta_key', 'meta_value'];

    public static function getValue($key) {
        try{
            return optional(self::where('meta_key', $key)->first())->meta_value;
        } catch(\Throwable $e){
            Log::error("Setting::getValue('$key') failed: " . $e->getMessage());
            return null;
        }
        
    }

    public static function setValue($key, $value) {
        return self::updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    

}
