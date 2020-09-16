<?php


namespace Nfra\Status\Type;


use Nfra\Status\ObjectMap;

class TContainer
{
    use ObjectMap;
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var bool
     */
    public $update_required = false;


    /**
     * @var string[]
     */
    public $packages_affected = [];

    /**
     * @var string|null
     */
    public $date_open = null;

}