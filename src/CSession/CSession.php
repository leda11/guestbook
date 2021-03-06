<?php
    /**
    * A wraper -for the session. 
    * Responsibility; read and store values on session. Maintains flash values for one pageload.    * 
    * 
    * FUNCTIONS
    * function StoreInSession()
    * function __get($key)
    * function SetFlash($key, $value)
    * function GetFlash($key)
    * function PopulateFromSession()
    * function AddMessage($type, $message)
    * function GetMessages()
    *
    * @package HandyCore
    */
    class CSession {
    
    	/**
    	* Members
   		*/
   		private $key;
   		private $data = array();
   		private $flash = null;
//------------------------------------------------------------------------------

    	/**
       * Store values into session.
       * $this->key sätts i konstruktorn och är konfigurerbar via en rad i site/config.php
       * $ha->config['session_key']  = 'handy';
       * Anropas från CObject-> RedirectTo($url)
       */
      
      public function StoreInSession() {
        $_SESSION[$this->key] = $this->data;// €this->data innehåller all min data och Handys data
      }     
// ------------------------------------------------------------------------------      
 /**
   * Set values
   */
  public function __set($key, $value) {
    $this->data[$key] = $value;
  }
// ------------------------------------------------------------------------------      

  /**
   * Get values
   */
  public function __get($key) {
    return isset($this->data[$key]) ? $this->data[$key] : null;
  }
// ------------------------------------------------------------------------------      

	/**
       * Set flash values, to be remembered one page request
       * used in CObject->RedirectTo($url)
       */
      public function SetFlash($key, $value) {
        $this->data['flash'][$key] = $value;
      }
// ------------------------------------------------------------------------------

    
      /**
       * Get flash values, if any.
       */
      public function GetFlash($key) {
        return isset($this->flash[$key]) ? $this->flash[$key] : null;
      }
//------------------------------------------------------------------------------    
  
      /**
       * Store values from this object into the session.
       */
      public function PopulateFromSession() {
        if(isset($_SESSION[$this->key])) {
          $this->data = $_SESSION[$this->key];
          if(isset($this->data['flash'])) {
            $this->flash = $this->data['flash'];
            unset($this->data['flash']);
          }
        }
      }
//------------------------------------------------------------------------------

      /**
       * Add message to be displayed to user on next pageload. Store in flash.
       *
       * @param $type string the type of message, for example: notice, info, success, warning, error.
       * @param $message string the message.
       */
      public function AddMessage($type, $message) {
        $this->data['flash']['messages'][] = array('type' => $type, 'message' => $message);
      }
//------------------------------------------------------------------------------
      
      /**
   * Get messages, if any. Each message is composed of a key and value. Use the key for styling.
   *
   * @returns array of messages. Each array-item contains a key and value.
   */
  public function GetMessages() {
    return isset($this->flash['messages']) ? $this->flash['messages'] : null;
  }
 }
