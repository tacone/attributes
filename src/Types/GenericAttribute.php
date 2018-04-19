<?php

namespace Attributes\Types;


class GenericAttribute
{
    protected $target = null;
    protected $return;
    protected $path = '';

    /**
     * @param $target
     * @param $path
     * @param $return
     * @return static
     */

    public static function make(&$target, $path, $return)
    {
        $instance = new static;
        $instance->target =& $target;
        $instance->path = $path;
        $instance->return = $return;

        return $instance;
    }

    public function handle($value = null)
    {

        if (!func_num_args()) {
            return $this->get();
        }

        $this->set($value);

        return $this->return;
    }

    protected function set($value)
    {
        $this->target[$this->path] = $value;
    }

    protected function get()
    {
        return isset($this->target[$this->path]) ? $this->target[$this->path] : null;
}
}
