    <?php
    /**
    * A guestbook controller as an example to show off some basic controller and model-stuff.
    *
    * @package HandyCore
    */
    class CCGuestbook extends CObject implements IController {

      private $pageTitle = 'Handy my Guestbook';
      private $pageHeader = '<h1>Guestbook </h1><p>Hi, welcome to my gustbook.<br/>Please add your input. <p>';
      private $pageForm ="";
      private $pageMessages= "<h2>Messages in the guestbook</h2>";
     
     
//------------------------------------------------------------------------------
      /**
       * Constructor
       */
      public function __construct() {
        parent::__construct();
      }
     
//------------------------------------------------------------------------------
      /**
       * Implementing interface IController. All controllers must have an index action.
       */
      public function Index() {   
      	  
      $formAction = $this->request->CreateUrl('guestbook/add');
      $this->pageForm = "
      <form method='post' action='{$formAction}'>
          <p>
            <label>Comment: <br/>
            <textarea name='newEntry' id='textInput' ></textarea></label>
          </p>
          <p>      
            <input type='submit' name='doAdd' value='Add message' />
            <input type='submit' name='doClear' value='Clear all messages' />
            </p>
         </form>
      ";
      
        $this->data['title'] = $this->pageTitle;
        $this->data['main'] = $this->pageHeader . $this->pageForm . $this->pageMessages;
       
        // Show added messages 
      if(isset($_SESSION['guestbook'])) {
      	  
      	  foreach($_SESSION['guestbook'] as $val) {
      	  	  $this->data['main'] .= "<div id='comment'><p>At: {$val['time']}</p><p>{$val['entry']}</p></div>\n";
          }
      }
}
//------------------------------------------------------------------------------
      /**
       * Implementing interface IController. All controllers must have an index action.
       */
      public function Add() {   
      	    
        if(isset($_POST['doAdd'])) {
          $entry = strip_tags($_POST['newEntry']);
          $time = date('r');
          $_SESSION['guestbook'][] = array('time'=>$time, 'entry'=>$entry);
        }
        elseif(isset($_POST['doClear'])) {
          unset($_SESSION['guestbook']);
        }           
        header('Location: ' . $this->request->CreateUrl('guestbook'));
        exit();
      }
    } 
    

