<?php
/**
* Holding a instance of CLydia to enable use of $this in subclasses.
*
* @package HandyCore
*/
class CObject {

   public $config;
   public $request;
   public $data;

   /**
    * Constructor
    */
   protected function __construct() {
    $ha = CHandy::Instance();
    $this->config   = &$ha->config;
    $this->request  = &$ha->request;
    $this->data     = &$ha->data;
  }

}
