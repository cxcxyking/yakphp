<?php

use Yak\System\Context;
use Yak\System\Application;

abstract class YakControllerAbstract
{
    protected $view = null;

    final public function __construct(YakRouteIntent $intent, ...$arguments)
    {
        $this->view = new Smarty();
        $this->view->setTemplateDir($this->getApplication()->getViewDir());
        if (method_exists($this, 'init')) {
            call_user_func([$this, 'init'], $intent, ...$arguments);
        }
    }

    public function getContext(): Context
    {
        return Context::getContext();
    }

    public function getApplication(): YakApplication
    {
        return Context::getApplication();
    }
}