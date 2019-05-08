<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/8
 * Time: 17:06
 */

namespace GoSwoole\Plugins\Security;

use GoSwoole\Plugins\Security\Beans\Principal;
use GoSwoole\Plugins\Session\GetSession;

trait GetSecurity
{
    use GetSession;

    public function getPrincipal(): ?Principal
    {
        return $this->getSession()->getAttribute("Principal");
    }

    public function setPrincipal(Principal $principal)
    {
        $this->getSession()->setAttribute("Principal", $principal);
    }
}