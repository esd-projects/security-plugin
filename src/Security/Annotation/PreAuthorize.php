<?php
/**
 * Created by PhpStorm.
 * User: administrato
 * Date: 2019/5/8
 * Time: 15:51
 */

namespace GoSwoole\Plugins\Cache\Annotation;


use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class PreAuthorize extends Annotation
{
    /**
     * @var string
     */
    public $value;
}