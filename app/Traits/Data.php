<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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

    //  GENERATE RANDOM PASSWORD
    public static function generate_password(){
        return Str::random(8);
//        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
//        return substr($random, 0, 10);
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


    // AUTHORIZATION LOGIN SESSION

    public function authorizeUser($value){
        if(Session::has('authorizeOperation')) {
            if (time() > Session::get('authorizeOperation')['time']) {
                Session::forget('authorizeOperation');
                if (!Session::has('authorizeOperation')) {
                    $this->emitUp('authorizeLogin', [true,$value]);
                    return false;
                } else {
                    return true;

                }
            } else {
                return true;
            }
        }else{
            $this->emitUp('authorizeLogin', [true,$value]);
            return false;
        }
    }

    public function reauthorizeUser($value){
        Session::forget('authorizeOperation');
       return  $this->authorizeUser($value);
    }
}
