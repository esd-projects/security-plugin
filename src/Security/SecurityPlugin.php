<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/8
 * Time: 15:34
 */

namespace ESD\Plugins\Security;

use ESD\BaseServer\Server\Context;
use ESD\BaseServer\Server\PlugIn\AbstractPlugin;
use ESD\BaseServer\Server\PlugIn\PluginInterfaceManager;
use ESD\BaseServer\Server\Server;
use ESD\Plugins\Aop\AopPlugin;
use ESD\Plugins\Security\Aspect\SecurityAspect;
use ESD\Plugins\Session\SessionPlugin;

class SecurityPlugin extends AbstractPlugin
{
    /**
     * @var SecurityConfig|null
     */
    private $securityConfig;

    /**
     * 获取插件名字
     * @return string
     */
    public function getName(): string
    {
        return "Security";
    }

    /**
     * CachePlugin constructor.
     * @param SecurityConfig|null $securityConfig
     * @throws \DI\DependencyException
     * @throws \ReflectionException
     */
    public function __construct(?SecurityConfig $securityConfig = null)
    {
        parent::__construct();
        $this->atAfter(AopPlugin::class);
        $this->atAfter(SessionPlugin::class);
        if ($securityConfig == null) {
            $securityConfig = new SecurityConfig();
        }
        $this->securityConfig = $securityConfig;
    }

    /**
     * @param PluginInterfaceManager $pluginInterfaceManager
     * @return mixed|void
     * @throws \DI\DependencyException
     * @throws \ESD\BaseServer\Exception
     * @throws \ReflectionException
     */
    public function onAdded(PluginInterfaceManager $pluginInterfaceManager)
    {
        parent::onAdded($pluginInterfaceManager);
        $pluginInterfaceManager->addPlug(new AopPlugin());
        $pluginInterfaceManager->addPlug(new SessionPlugin());
    }


    /**
     * 在服务启动前
     * @param Context $context
     * @return mixed
     * @throws \ESD\BaseServer\Server\Exception\ConfigException
     */
    public function beforeServerStart(Context $context)
    {
        $this->securityConfig->merge();
        $aopPlugin = Server::$instance->getPlugManager()->getPlug(AopPlugin::class);
        if ($aopPlugin instanceof AopPlugin) {
            $aopPlugin->getAopConfig()->addAspect(new SecurityAspect());
        }
    }

    /**
     * 在进程启动前
     * @param Context $context
     * @return mixed
     */
    public function beforeProcessStart(Context $context)
    {
        $this->ready();
    }
}