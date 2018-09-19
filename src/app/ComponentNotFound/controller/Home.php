<?php

namespace YakInstance\ComponentNotFound\Controller;

use YakRouteIntent;
use YakControllerAbstract;

class Home extends YakControllerAbstract
{
    public function init(YakRouteIntent $intent)
    {
        if ($intent->get('originIntent', null) !== null) {
            $this->view->assign('controller', $intent->get('originIntent')->getController());
            $this->view->assign('action', $intent->get('originIntent')->getAction());
            $this->view->assign('model', $intent->get('originIntent')->getModel());
            $this->view->assign('view', $intent->get('originIntent')->getView());
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