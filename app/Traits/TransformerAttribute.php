<?php

namespace App\Traits;

trait TransformerAttribute
{
    public static function getOriginalAttribute($index)
    {
        return self::$attributes[$index] ?? null;
    }

    public static function transformedAttribute($index)
    {
        $flip = array_flip(self::$attributes);

        return $flip[$index] ?? null;
    }
}
