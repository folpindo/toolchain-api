<?php

namespace Toolchain;

/**
 * Abstract for Toolchain services.
 * 
 */
abstract class ServiceAbstract {

    /**
     *
     * @var type 
     */
    protected $_request;

    /**
     *
     * @var type 
     */
    protected $_response;

    /**
     *
     * @var type 
     */
    protected $_server_status;

    /**
     *
     * @var type 
     */
    protected $_request_status = '200';

    /**
     *
     * @var type 
     */
    protected $_message;

    /**
     *
     * @var type 
     */
    protected $_name;

    /**
     *
     * @var type 
     */
    protected $_options = array();

    /**
     *
     * @var type 
     */
    protected $_method;

    public function setOptions($options) {
        $this->_options = $options;
    }

    public function init() {
        
    }

    public function initDatabase() {
        
    }

    /**
     * 
     * @param type $config
     */
    public function setConfig($config) {
        $this->_config = $config;
    }

    /**
     * 
     * @param type $request
     */
    public function setRequest($request) {
        $this->_request = $request;
    }

    /**
     * 
     * @param type $response
     */
    public function setResponse($response) {
        $this->_response = $response;
    }

    /**
     * 
     * @return type
     */
    public function getConfig() {
        return $this->_config;
    }

    /**
     * 
     * @return type
     */
    public function getRequest() {
        return $this->_request;
    }

    /**
     * 
     * @return type
     */
    public function getResponse() {
        return $this->_response;
    }

    /**
     * 
     * @param type $status
     */
    public function setServerStatus($status) {
        $this->_server_status = $status;
    }

    /**
     * 
     * @param type $status
     */
    public function setRequestStatus($status) {
        $this->_request_status = $status;
    }

    /**
     * 
     * @param type $message
     */
    public function setMessage($message) {
        $this->_message = $message;
    }

    /**
     * 
     * @return type
     */
    public function getServerStatus() {
        return $this->_server_status;
    }

    /**
     * 
     * @return type
     */
    public function getRequestStatus() {
        return $this->_request_status;
    }

    /**
     * 
     * @return type
     */
    public function getMesage() {
        return $this->_message;
    }

    /**
     * 
     * @return type
     */
    public function getOptions() {
        return $this->_options;
    }

    /**
     * 
     * @param type $method
     */
    public function setMethod($method) {
        $this->_method = $method;
    }

    /**
     * 
     * @return type
     */
    public function getMethod() {
        return $this->_method;
    }

    /**
     * 
     * @return type
     */
    public function getStatus() {
        return $this->_request_status;
    }

    /**
     * 
     * @return type
     */
    protected function getName() {
        return $this->_name;
    }

    /**
     * 
     * @param type $method
     * @param type $opions
     * @return boolean
     */
    protected function call($method, $opions = array()) {

        $options = $this->getOptions();
        if (method_exists($this, $method)) {
            return $this->$method($options);
        } else {
            $this->setRequestStatus('404');
            return false;
        }
    }

    /**
     * Echoes the result of the call in json.
     */
    public function result() {

        $version = $this->_version;
        $service = $this->getName();
        $server_status = 'ok';
        $method = $this->getMethod();
        $message = 'Operation successful.';
        $options = $this->getOptions();
        $result = $this->call($method, $options);
        $status = $this->getStatus();

        echo json_encode(
                array(
                    'server_status' => $server_status,
                    'method' => $method,
                    'call_status' => $status,
                    'message' => $message,
                    'version' => $version,
                    'service' => $service,
                    'result' => $result
                )
        );
    }

}
