<?php
class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;
    /**
     * @var null Model
     */
    public $model = null;
    /**
     * Whenever controller is created, open a database connection too and load "the model".
     */
    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }
    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // generate a database connection
        try {
          $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS);
        } catch(Exception $e) {
          echo 'Caught Exception: ', $e->getMessage(), "\n";
          exit();
        }
        // check Connection
        if ($this->db->connect_errno) {
          printf('Connection Error: %s\n', $mysql->connect_error);
          exit();
        }


    }
    /**
     * Loads the "model".
     * @return object model
     */
    public function loadModel()
    {
        require APP . 'model/model.php';
        // create new "model" (and pass the database connection)
        $this->model = new Model($this->db);
    }
    /**
     * Function to destroy a session and its data
     *
     */
     public function destroy_session_and_data() {
       session_start();
       $_SESSION = array();
       setcookie(session_name(), '', time() - 2592000, '/');
       session_destroy();
     }

     /**
      * Function when session checks fail
      *
      */
      public function differentUser() {
        $this->destroy_session_and_data();
        $message = 'Server Error: Please Re-Login';
        header("Location: /VirusTester/users/login");
        exit();
      }
}
?>
