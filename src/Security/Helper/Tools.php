<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/7/14
 * Time: 19:51
 */

namespace ESD\Plugins\Security\Helper;


class Tools
{
    public static function netMatch($client_ip, $server_ip, $mask)
    {
        $mask1 = 32 - $mask;
        return ((ip2long($client_ip) >> $mask1) == (ip2long($server_ip) >> $mask1));
    }
}