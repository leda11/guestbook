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
      	  
      $formAction = $this->request->CreateUrl('guestbook/handler');
      $this->pageForm = "
      <form method='post' action='{$formAction}'>
          <p>
            <label>Comment: <br/>
            <textarea name='newEntry' id='textInput' ></textarea></label>
          </p>
          <p>      
            <input type='submit' name='doAdd' value='Add message' />
            <input type='submit' name='doClear' value='Clear all messages' />
            <input type='submit' name='doCreate' value='Skapa databasen' />
           </p>
         </form>
      ";
      
        $this->data['title'] = $this->pageTitle;
        $this->data['main'] = $this->pageHeader . $this->pageForm . $this->pageMessages;
       
        // Show added messages 
        $comments = $this->ReadAllFromDatabase();// calls ExecuteSelectQueryAndFetchAll
        foreach ($comments as $val){
        	$this->data['main'] .= "<div id='comment'><p>At: {$val['created']}</p><p>{$val['entry']}</p></div>\n";
        }
      /*
      if(isset($_SESSION['guestbook'])) {
      	  
      	  foreach($_SESSION['guestbook'] as $val) {
      	  	  $this->data['main'] .= "<div id='comment'><p>At: {$val['time']}</p><p>{$val['entry']}</p></div>\n";
          }
      }*/
}

//------------------------------------------------------------------------------
      /**
       * Save a new entry to database.
       */
      private function CreateTableInDatabase() {
        try {
          $this->db->ExecuteQuery("CREATE TABLE IF NOT EXISTS Guestbook (id INTEGER PRIMARY KEY, entry TEXT, created DATETIME default (datetime('now')));");
        } catch(Exception$e) {
          die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
        }
      }
/*      private function CreateTableInDatabase() {
        try {
          $db = new PDO($this->config['database'][0]['dsn']);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
     
          $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS Guestbook (id INTEGER PRIMARY KEY, entry TEXT, created DATETIME default (datetime('now')));");
          $stmt->execute();
        } catch(Exception$e) {
          die("Failed to open database: " . $this->config['database'][0]['dsn'] . "</br>" . $e);
        }
      }
*/
//------------------------------------------------------------------------------
      /**
       * Handle posts from the form and take appropriate action.
       */
      public function Handler() {
        if(isset($_POST['doAdd'])) {
          $this->SaveNewToDatabase(strip_tags($_POST['newEntry']));//calls ExecuteQuery
        }
        elseif(isset($_POST['doClear'])) { // calls ExecuteQuery
          $this->DeleteAllFromDatabase();
        }        
        elseif(isset($_POST['doCreate'])) {
          $this->CreateTableInDatabase();
        }           
        header('Location: ' . $this->request->CreateUrl('guestbook'));
      }
//------------------------------------------------------------------------------
        
/*      public function Add() {   
      	    
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
 */

//------------------------------------------------------------------------------
      /**
       * Save a new entry to database.
       */
      private function SaveNewToDatabase($entry) {
        $this->db->ExecuteQuery('INSERT INTO Guestbook (entry) VALUES (?);', array($entry));
        if($this->db->rowCount() != 1) {
          echo 'Failed to insert new guestbook item into database.';
        }
      }
      
      /*
      private function SaveNewToDatabase($entry) {
        $db = new PDO($this->config['database'][0]['dsn']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $db->prepare('INSERT INTO Guestbook (entry) VALUES (?);');
        $stmt->execute(array($entry));
        if($stmt->rowCount() != 1) {
          die('Failed to insert new guestbook item into database.');
        }
      }*/
//------------------------------------------------------------------------------
      /**
       * Delete all entries from the database.
       */
      private function DeleteAllFromDatabase() {
        $this->db->ExecuteQuery('DELETE FROM Guestbook;');
      }
      
       /*
      private function DeleteAllFromDatabase() {
        $db = new PDO($this->config['database'][0]['dsn']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $db->prepare('DELETE FROM Guestbook;');
        $stmt->execute();
      }*/
 //------------------------------------------------------------------------------
     /**
       * Read all entries from the database.
       */
      private function ReadAllFromDatabase() {
        try {
          $this->db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $this->db->ExecuteSelectQueryAndFetchAll('SELECT * FROM Guestbook ORDER BY id DESC;');
        } catch(Exception $e) {
          return array();   
        }
      }
      
      /*
      private function ReadAllFromDatabase() {
        try {
          $db = new PDO($this->config['database'][0]['dsn']);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
          $stmt = $db->prepare('SELECT * FROM Guestbook ORDER BY id DESC;');
          $stmt->execute();
          $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $res;
        } catch(Exception $e) {
          return array();
        }
      }*/
    } 
    

