<?php

namespace YakInstance\Hello\Controller;


class Home extends \YakControllerAbstract
{
    public function hello(\YakRouteIntent $intent)
    {
        $this->view->assign('controller', $intent->getController());
        $this->view->assign('action', $intent->getAction());
        $this->view->assign('model', $intent->getModel());
        $this->view->assign('view', $intent->getView());
        $this->view->display('index.html');

        echo $this->getApplication()->getSettings('version');
    }
}