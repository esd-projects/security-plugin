<?php
/**
 * Created by PhpStorm.
 * User: administrato
 * Date: 2019/5/8
 * Time: 15:51
 */

namespace GoSwoole\Plugins\Security\Annotation;


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
}