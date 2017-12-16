<?php
/**
 * Class Home
 *
 */
class Home extends Controller
{
    /**
     * PAGE: .../home/
     * Session checks for user ip and browser, if not the same, asks for re-login
     *
     * @var    integer    $userID    integer representing the user, used to toggle user exclusive functions
     * @return void
     * @author Christopher Kang
     */
    public function index() {
      session_start();
      if (isset($_SESSION['check'])) {
        if ($_SESSION['check'] != hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']))
          $this->differentUser();
      }
      if (isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
      }

      require APP . 'view/_templates/header.php';
      require APP . 'view/home/index.php';
      require APP . 'view/_templates/footer.php';
    }
    /**
     * PAGE + ACTION: .../home/scan
     * Validates upload file, and scans file against virus database
     *
     * @var    integer    $userID     integer representing the user, used to toggle user exclusive functions
     * @var    string     $filePath   path to file
     * @var    array      $file       array of file info
     * @var    array      $result     array of virus and the index where it is first noticed
     * @return void
     * @author Christopher Kang
     */
    public function scan() {
      session_start();

      if (isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
      }

      if (isset($_FILES['scan_filename']['name'])) {
        $filePath = $this->validateFile($_FILES['scan_filename']);
        if ($filePath) {
          $file = $_FILES['scan_filename'];
          $result = $this->scanFile($filePath);
        }
      }

      require APP . 'view/_templates/header.php';
      require APP . 'view/home/scan.php';
      require APP . 'view/_templates/footer.php';

    }
    /**
     * PAGE + ACTION: .../home/store
     * Validates upload file, and stores virus signature into database
     *
     * @var    string     $fail         string of failure statements
     * @var    integer    $userID       integer representing the user, used to toggle user exclusive functions
     * @var    string     $virusName    name of virus input
     * @var    string     $filePath     path to file
     * @var    array      $file         array of file info
     * @var    string     $twentybytes  signature of file uploaded
     * @return void
     * @author Christopher Kang
     */
    public function store() {
      session_start();
      $fail = null;
      if (isset($_SESSION['userID'])) {
        $userID = $_SESSION['userID'];
      }

      if (isset($_POST['storesubmit'])) {
        if (isset($_POST['virus_name'])) {
          $virusName = $this->mysql_entities_fix_string($_POST['virus_name']);
        }
        $fail = $this->validate_name($virusName);

        if ($fail == "") {
          // file handling
          if (isset($_FILES['store_filename']['name'])) {
            $filePath = $this->validateFile($_FILES['store_filename']);
            if ($filePath) {
              $file = $_FILES['store_filename'];
              $twentybytes = $this->parseFile($filePath);
              $fail .= $this->model->addVirus($virusName, $twentybytes);
              $twentybytes = chunk_split($twentybytes,75,"<br>");
            }
          }
        }
      }
      // load views
      require APP . 'view/_templates/header.php';
      require APP . 'view/home/store.php';
      require APP . 'view/_templates/footer.php';
    }
    /**
      * Function validateFile
      *
      * @param  array   $fArr   info array provided by _FILES
      * @return boolean         false if not valid file
      * @return string          temporary filepath for uploads
      * @author Christopher Kang
      */
    private function validateFile($fArr) {
        if($fArr['error'] > 0){
          echo $fArr['error']; return false;
        }

        if($fArr['size'] > 500000) {
          echo 'exceed upload size'; return false;
        }

        return $fArr['tmp_name'];
      }
    /**
      * Function validate_name
      * Take in form field, Checks for contents, length, and characters
      *
      * @param  string   $field   form field provided by POST request
      * @return string            "" if valid, error if not
      * @author Christopher Kang
      */
     private function validate_name($field) {
      if ($field == "")
        return "Virus Name cannot be blank.\n";
      else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
        return "Only a-z, A-Z, 0-9 allowed in Virus Name.\n";
      return "";
    }
    /**
      * Function scanFile
      *
      * @param  string   $filePath    path to file
      * @var    string   $char        string representation of file
      * @var    array    $byteArray   array represenation of file
      * @return array    $result      array of viruses found and index first spotted
      * @author Christopher Kang
      */
      private function scanFile($filepath) {
        $char = '';
        if (!file_exists($filepath)) { return false;}
        $byteArray = unpack("N*", file_get_contents($filepath));
        for($i = 1; $i < count($byteArray); $i++) {
            $char .= $byteArray[$i];
        }
        $result = $this->model->checkVirus($char);

        return $result;
      }
    /**
      * Function storeFile
      * return first 20 bytes of file as string
      *
      * @param  string     $filePath   path to file
      * @var    string     $char       string representation of file
      * @var    array      $byteArray  array representation of file
      * @return string     $char       signature of file
      * @author Christopher Kang
      */
      private function parseFile($filepath) {
        $char = '';
        if (!file_exists($filepath)) { return false;}
        $byteArray = unpack("N*", file_get_contents($filepath));


        for($i = 1; $i < 21; $i++)
        {
            $char .= $byteArray[$i];
        }

        return $char;
      }
    /**
      * Function fix_string
      * convert string to mysql safe string
      *
      * @param  string   $string  dirty string
      * @return string   $string  clean string
      * @author Christopher Kang
      */
      private function mysql_fix_string($string) {
          if(get_magic_quotes_gpc()) $string = stripslashes($string);
          return $this->db->real_escape_string($string);
      }

      private function mysql_entities_fix_string($string) {
          return htmlentities($this->mysql_fix_string($string));
      }
}
?>
