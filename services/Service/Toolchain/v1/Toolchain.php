<?php

namespace Service\Toolchain\v1;
/**
 * Default service object for toolchain.
 * 
 */
class Toolchain extends \Toolchain\ServiceAbstract {
    /**
     *
     * @var type 
     */
    protected $_version = 'v1';
    /**
     *
     * @var type 
     */
    protected $_name = 'Toolchain';
    
    /**
     * Test method
     * 
     * @param type $options
     * @return type
     */
    public function test($options = array()){
        return array('test'=> 'ok');
    }

}
