<?php
/**
 * Created by PhpStorm.
 * User: administrato
 * Date: 2019/5/8
 * Time: 15:44
 */

namespace GoSwoole\Plugins\Security;


use GoSwoole\BaseServer\Plugins\Config\BaseConfig;

class SecurityConfig extends BaseConfig
{
    const key = "security";

    public function __construct()
    {
        parent::__construct(self::key);
    }
}