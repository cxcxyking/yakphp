<?php

namespace YakInstance\ComponentNotFound\Controller;

use YakRouteIntent;
use YakControllerAbstract;

class Home extends YakControllerAbstract
{
    public function init(YakRouteIntent $intent)
    {
        if (($target = $intent->get('origin', null)) !== null) {
            $this->view->assign('controller', $target->getTarget());
            $this->view->assign('action', $intent->get('origin'));
            $this->view->assign('model', $intent->get('origin'));
            $this->view->assign('view', $intent->get('origin'));
        }
    }

    public function controllerNotFound(YakRouteIntent $intent)
    {
        $this->view->display('ControllerNotFound.html');
    }

    public function actionNotFound(YakRouteIntent $intent)
    {
        $this->view->display('ActionNotFound.html');
    }

    public function modelNotFound(YakRouteIntent $intent)
    {
        $this->view->display('ModelNotFound.html');
    }

    public function viewNotFound(YakRouteIntent $intent)
    {
        $this->view->display('ViewNotFound.html');
    }

    public function routeNotFound(YakRouteIntent $intent)
    {
        $this->view->display('RouteNotFound.html');
    }
}