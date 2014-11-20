<?php

namespace Toolchain;

/**
 * Use to initialize service requested.
 * 
 */
class ServiceFactory {

    /**
     *
     * @var type
     */
    protected static $_instance;
    /**
     * Singleton construct.
     * 
     */
    private function __construct() {}

    /**
     * Returns the object instance of this class.
     * 
     * @return type
     */
    public function getInstance() {
        return (self::$_instance == null) ? (new self()) : self::$_instance;
    }

    /**
     * 
     * @param type $service
     * @param type $version
     * @param type $method
     * @param type $source
     * @return \Toolchain\serviceClass
     * @throws \Toolchain\ServiceFactoryException
     */
    public function getService($service, $version, $method, $source = null) {
        $serviceClass = '_Service_' . $service . '_' . $version . '_' . $service;
        $serviceClass = str_replace('_', '\\', $serviceClass);
        if (class_exists($serviceClass)) {
            $serviceObject = new $serviceClass();
            $serviceObject->setMethod($method);
            return $serviceObject;
        } else {
            throw new \Toolchain\ServiceFactoryException("The service does not exist.");
        }
    }

}
