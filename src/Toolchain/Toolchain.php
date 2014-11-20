<?php

namespace Toolchain;
/**
 * Main toolchain
 */
class Toolchain {

    /**
     * Service Factory
     * @var type 
     */
    protected $_factory;
    /**
     * Base REST framework.
     * 
     * @var type 
     */
    protected $_handler;

    /**
     * 
     * @param type $factory
     */
    public function setServiceFactory($factory) {
        $this->_factory = $factory;
    }

    /**
     * 
     * @param type $handler
     */
    public function setHandler($handler) {
        $this->_handler = $handler;
    }

    /**
     * 
     * @return type
     */
    public function getServiceFactory() {
        return $this->_factory;
    }

    /**
     * 
     * @return type
     */
    public function getHandler() {
        return $this->_handler;
    }

    /**
     * Default rest/api handler.
     * 
     */
    public function initHandler() {
        if (!isset($this->_handler)) {
            $this->_handler = new \Slim\Slim();
        }
    }

    /**
     * Initializes default service object factory/loader.
     * 
     */
    public function initFactory() {
        if (!isset($this->_factory)) {
            $this->_factory = \Toolchain\ServiceFactory::getInstance();
        }
    }

    /**
     * Initializes objects.
     * 
     */
    public function init() {
        $this->initFactory();
        $this->initHandler();
    }

    /**
     * Sets headers. The default is in json.
     * 
     */
    public function setHeaders() {
        $app = $this->getHandler();
        $app->response()->header("Content-Type", "application/json");
        $app->response()->header("Cache-Control", "no-cache, must-revalidate");
        $app->response()->header("Expires", "Sat, 26 Jul 1997 05:00:00 GMT");
    }

    /**
     * Initial routing
     * 
     */
    public function setRoutes() {
        $app = $this->getHandler();
        $serviceFactory = $this->getServiceFactory();
        $app->get('/:version/:service/:method', function ($version, $service, $method) use ($app, $serviceFactory, $r) {
            $req = $app->request->params();
            $serviceObject = $serviceFactory->getService($service, $version, $method, $app);
            $serviceObject->setRequest(json_decode(json_encode($req)));
            $serviceObject->result();
        });

        $app->post('/:version/:service/:method', function ($version, $service, $method) use ($app, $serviceFactory) {
            $req = $app->request->post();
            $serviceObject = $serviceFactory->getService($service, $version, $method, $app);
            $serviceObject->setRequest(json_decode(json_encode($req)));
            $serviceObject->result();
        });
        
        $app->get('/:version/:service', function ($version, $service) use ($app, $serviceFactory, $r) {
            $req = $app->request->params();
            $serviceObject = $serviceFactory->getService($service, $version, null, $app);
            $serviceObject->setRequest(json_decode(json_encode($req)));
            $serviceObject->result();
        });

        $app->post('/:version/:service', function ($version, $service) use ($app, $serviceFactory) {
            $req = $app->request->post();
            $serviceObject = $serviceFactory->getService($service, $version, null, $app);
            $serviceObject->setRequest(json_decode(json_encode($req)));
            $serviceObject->result();
        });
    }

    /**
     * Dispatches request.
     * 
     */
    public function run() {
        $this->setRoutes();
        $this->setHeaders();
        $app = $this->getHandler();
        $app->run();
    }

}
