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

    /**
     * @param $value
     * @return static|integer|float|null|resource|object|array|string
     */
    public function handle(array $arguments = [])
    {
        if (!func_num_args()) {
            $trace = debug_backtrace();
            $arguments = $trace[1]['args'];
        }

        if (!count($arguments)) {
            return $this->get();
        }

        $this->set($arguments[0]);

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
