<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/8
 * Time: 15:51
 */

namespace ESD\Plugins\Security\Annotation;


use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class PostAuthorize extends Annotation
{
    /**
     * @var string
     */
    public $value;

    /**
     * @var array|string
     */
    public $roles = [];

    /**
     * @var array|string
     */
    public $ips = [];

    /**
     * @var bool
     */
    public $all = false;

    /**
     * @var bool
     */
    public $deny = false;
}