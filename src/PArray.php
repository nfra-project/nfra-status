<?php


namespace Nfra\Status;


class PArray
{
    private $arr;

    public function __construct(array $array)
    {
        $this->arr = $array;
    }

    public function map(callable $fn) : self
    {
        $ret = [];
        foreach ($this->arr as $key => $value) {
            $val = $fn($key, $value, $this->arr);
            if ($val === null)
                continue;
            $ret[] = $val;
        }

        return new PArray($ret);
    }


    public function call(callable $cb) : self
    {
        $val = $cb(...$this->arr);
        if ($val === null)
            return new PArray([]);
        return new PArray($val);
    }
}