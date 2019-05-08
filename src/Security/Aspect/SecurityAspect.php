<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/8
 * Time: 17:36
 */

namespace GoSwoole\Plugins\Security\Aspect;

use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use Go\Lang\Annotation\Aspect;
use GoSwoole\Plugins\Security\Annotation\PostAuthorize;
use GoSwoole\Plugins\Security\Annotation\PreAuthorize;
use GoSwoole\Plugins\Security\AccessDeniedException;

class SecurityAspect extends Aspect
{
    /**
     * @param MethodInvocation $invocation Invocation
     *
     * @Around("@execution(GoSwoole\Plugins\Security\Annotation\PostAuthorize)")
     * @return mixed
     * @throws AccessDeniedException
     */
    public function aroundPostAuthorize(MethodInvocation $invocation)
    {
        $postAuthorize = $invocation->getMethod()->getAnnotation(PostAuthorize::class);
        $p = $invocation->getArguments();
        $returnObject = $invocation->proceed();
        $ex = eval("return ($postAuthorize->value);");
        if ($ex) {
            return $returnObject;
        } else {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param MethodInvocation $invocation Invocation
     *
     * @Around("@execution(GoSwoole\Plugins\Security\Annotation\PreAuthorize)")
     * @return mixed
     * @throws AccessDeniedException
     */
    public function aroundPreAuthorize(MethodInvocation $invocation)
    {
        $preAuthorize = $invocation->getMethod()->getAnnotation(PreAuthorize::class);
        $p = $invocation->getArguments();
        $ex = eval("return ($preAuthorize->value);");
        if ($ex) {
            return $invocation->proceed();
        } else {
            throw new AccessDeniedException();
        }
    }
}