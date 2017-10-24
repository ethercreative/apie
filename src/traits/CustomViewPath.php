<?php

namespace ethercreative\apie\traits;

trait CustomViewPath
{
    public $viewPath, $views = [];

    public function getCustomViewPath($action)
    {
        if (!empty($this->views[$action]))
            return $this->views[$action];

        return $this->viewPath . '/' . $action;
    }
}
