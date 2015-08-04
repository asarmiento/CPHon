<?php

namespace AccountHon\Http\Middleware;

class Counter extends IsTypeGlobal
{
    public function getType()
    {
        return 3;
    }
}
