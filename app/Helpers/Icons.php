<?php

namespace App\Helpers;

class Icons
{
    public static function pencil()
    {
        return '<i class="fas fa-edit"></i>';
    }

    public static function trash(): string
    {
        return '<i class="fas fa-trash"></i>';
    }

    public static function detail(): string
    {
        return '<i class="fa-solid fa-magnifying-glass-plus"></i>';
    }
}
