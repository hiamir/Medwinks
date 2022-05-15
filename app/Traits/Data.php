<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;

trait Data
{
    public static function capitalize_each_word($data)
    {
        return ucwords($data);
    }

    public static function all_upper_case($data)
    {
        return strtoupper($data);
    }

    public static function all_lower_case($data)
    {
        return strtolower($data);
    }

    //   DATA DIFFERENCE

    public static function capitalize_first_word($data)
    {
        return ucfirst($data);
    }

    // ROUTE NAMES WITH SEARCH

    public function routeNames($guard): array
    {
        $actions = [];

        foreach (Route::getRoutes()->get() as $value) {
            array_push($actions, $value->getAction('as'));
//            if ($this->startsWith($value->getAction('as'), $guard . ".")) {
//                array_push($actions, $value->getAction('as'));
//            }
        }
        return $actions;
    }

    // ROUTE NAMES WITH SEARCH

    public function all_routes(): array
    {
        $actions = [];
        foreach (Route::getRoutes()->get() as $value) {
            array_push($actions, $value->getAction('as'));
        }
        return $actions;
    }


    public function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
}
