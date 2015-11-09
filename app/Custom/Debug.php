<?php
/**
 * Created by PhpStorm.
 * User: laerteguedes
 * Date: 07/11/15
 * Time: 09:06
 */

namespace App\Custom;


class Debug
{

    public static function dump($var, $exit = true)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        ($exit) ? die() : '';
    }

    public static function showClassMethods($var, $exit = true)
    {
        $methods = get_class_methods($var);

        foreach ($methods as $method) {
            self::dump($method, false);
        }

        ($exit) ? die() : '';
    }

}