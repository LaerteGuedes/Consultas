<?php
/**
 * Created by PhpStorm.
 * User: laerteguedes
 * Date: 08/12/15
 * Time: 07:22
 */

namespace App\Custom;


class Util
{
    public static function getDiaDaSemana()
    {
        $diaDaSemana = date('N');

        switch($diaDaSemana){
            case 1:
                return 'seg';
                break;
            case 2:
                return 'ter';
                break;
            case 3:
                return 'qua';
                break;
            case 4:
                return 'qui';
                break;
            case 5:
                return 'sex';
                break;
            case 6:
                return 'sab';
                break;
            case 7:
                return 'dom';
                break;
            default:
                return false;
        }
    }

}