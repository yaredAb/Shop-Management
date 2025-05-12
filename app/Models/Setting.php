<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['meta_key', 'meta_value'];

    public static function getValue($key) {
        return optional(self::where('meta_key', $key)->first())->meta_value;
    }

    public static function setValue($key, $value) {
        return self::updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    

}
