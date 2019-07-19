<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/8
 * Time: 17:36
 */

namespace ESD\Plugins\Security\Aspect;

use ESD\Plugins\Aop\OrderAspect;
use ESD\Plugins\Security\AccessDeniedException;
use ESD\Plugins\Security\Annotation\PostAuthorize;
use ESD\Plugins\Security\Annotation\PreAuthorize;
use ESD\Plugins\Security\GetSecurity;
use ESD\Plugins\Security\SecurityConfig;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;

class SecurityAspect extends OrderAspect
{
    use GetSecurity;

    /**
     * @param MethodInvocation $invocation Invocation
     *
     * @Around("@execution(ESD\Plugins\Security\Annotation\PostAuthorize)")
     * @return mixed
     * @throws AccessDeniedException
     */
    public function aroundPostAuthorize(MethodInvocation $invocation)
    {
        $returnObject = $invocation->proceed();
        /** @var PostAuthorize $postAuthorize */
        $postAuthorize = $invocation->getMethod()->getAnnotation(PostAuthorize::class);

        if (!$this->isAuthenticated()) {
            throw new AccessDeniedException();
        }
        if ($postAuthorize->all) {
            return $returnObject;
        }
        if ($postAuthorize->deny) {
            throw new AccessDeniedException();
        }
        if ($postAuthorize->value && !$this->hasAnyPermission($postAuthorize->value)) {
            throw new AccessDeniedException();
        }
        /** @var SecurityConfig $securityConfig */
        $securityConfig = DIGet(SecurityConfig::class);
        $roles = array_merge($securityConfig->getIncludeRoles(), $postAuthorize->roles);
        if ($roles && !$this->hasAnyRole($postAuthorize->roles)) {
            throw new AccessDeniedException();
        }
        $ips = array_merge($securityConfig->getIncludeIps(), $postAuthorize->ips);
        if ($ips && !$this->hasIpAddress($postAuthorize->ips)) {
            throw new AccessDeniedException();
        }
        return $returnObject;
    }

    /**
     * @param MethodInvocation $invocation Invocation
     *
     * @Around("@execution(ESD\Plugins\Security\Annotation\PreAuthorize)")
     * @return mixed
     * @throws AccessDeniedException
     */
    public function aroundPreAuthorize(MethodInvocation $invocation)
    {
        $preAuthorize = $invocation->getMethod()->getAnnotation(PreAuthorize::class);
        if (!$this->isAuthenticated()) {
            throw new AccessDeniedException();
        }
        if ($preAuthorize->all) {
            return $invocation->proceed();
        }
        if ($preAuthorize->deny) {
            throw new AccessDeniedException();
        }
        if ($preAuthorize->value && !$this->hasAnyPermission($preAuthorize->value)) {
            throw new AccessDeniedException();
        }
        /** @var SecurityConfig $securityConfig */
        $securityConfig = DIGet(SecurityConfig::class);
        $roles = array_merge($securityConfig->getIncludeRoles(), $preAuthorize->roles);
        if ($roles && !$this->hasAnyRole($preAuthorize->roles)) {
            throw new AccessDeniedException();
        }
        $ips = array_merge($securityConfig->getIncludeIps(), $preAuthorize->ips);
        if ($ips && !$this->hasIpAddress($preAuthorize->ips)) {
            throw new AccessDeniedException();
        }
        return $invocation->proceed();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "SecurityAspect";
    }
}