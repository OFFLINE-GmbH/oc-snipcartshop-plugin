<?php

namespace OFFLINE\SnipcartShop\Components;

trait SetsVars
{
    protected function setVar($name, $value)
    {
        $this->{$name} = $this->page[$name] = $value;
    }
}