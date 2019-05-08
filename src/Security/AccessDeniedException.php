<?php
/**
 * Created by PhpStorm.
 * User: administrato
 * Date: 2019/5/8
 * Time: 16:23
 */

namespace GoSwoole\Plugins\Security;


use GoSwoole\BaseServer\Exception;

class AccessDeniedException extends Exception
{
    public function __construct()
    {
        parent::__construct("没有相应权限", 0, null);
    }
}