<?php

namespace Apps\Blog\model;

class Url
{
    public  static function getRootPath() : string
    {
        return substr(__DIR__, 0, strpos(__DIR__, 'src') + 3);
    }
}
