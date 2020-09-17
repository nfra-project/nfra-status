<?php


namespace Nfra\Status;




class PString
{
    private $str;


    public function __construct(string $str)
    {
        $this->str = $str;
    }

    public function explode($delimiter, $limit=null) : PArray
    {
        return new PArray(explode($delimiter, $this->str, $limit));
    }

}