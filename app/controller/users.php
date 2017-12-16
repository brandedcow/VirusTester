<?php
/**
 * Class Users
 *
 * class to manage users
 */
class Users extends controller {

  /**
   * PAGE: .../users/
   *
   * @return void
   * @author Christopher Kang
   */
  public function index() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/users/index.php';
    require APP . 'view/_templates/footer.php';
  }

  /**
   * PAGE + ACTION: .../users/login
   * Validates login info, searches database
   *
   * @var    integer    $userID     integer representing the user, used to toggle user exclusive functions
   * @var    string     $fail       string of errors
   * @var    string     $username   username input
   * @var    string     $password   password input
   * @return void
   * @author Christopher Kang
   */
  public function login() {
    session_start();
    $message = $fail = null;

    if (isset($_POST['username']))
      $username = $this->mysql_entities_fix_string($_POST['username']);
    if (isset($_POST['password']))
      $password = $this->mysql_entities_fix_string($_POST['password']);

    if (isset($_POST['submitted'])){
      $userID = $this->model->authUser($username, $password);
      if (($userID != null) && is_int($userID)) {
        session_regenerate_id();
        $_SESSION['userID'] = $userID;
        $_SESSION['check'] = hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
        header("Location: /VirusTester/home");
      } else {
        $message = "Invalid Username and Password Combination";
      }
    }

    require APP . 'view/_templates/header.php';
    require APP . 'view/users/login.php';
    require APP . 'view/_templates/footer.php';
  }

  /**
   * PAGE + ACTION: .../users/register
   * validates inputs, stores into database
   *
   * @var    integer    $userID     integer representing the user, used to toggle user exclusive functions
   * @var    string     $fail       string of errors
   * @var    string     $username   username input
   * @var    string     $email      email input
   * @var    string     $password   password input
   * @return void
   * @author Christopher Kang
   */
  public function register() {
    $username = $email = $password = "";
    $fail = null;

    if (isset($_POST['username']))
      $username = $this->mysql_entities_fix_string($_POST['username']);
    if (isset($_POST['email']))
      $email = $this->mysql_entities_fix_string($_POST['email']);
    if (isset($_POST['password']))
      $password = $this->mysql_entities_fix_string($_POST['password']);

    if (isset($_POST['submitted'])){
      $fail = $this->validate_username($username);
      $fail .= $this->validate_email($email);
      $fail .= $this->validate_password($password);

      if ($fail == "") {
        $fail .= $this->model->addUser($username, $email, $password);
      }
      if ($fail == "") {
        header("Location: /VirusTester/users/login");
      }
      $fail = nl2br($fail);
    }
    require APP . 'view/_templates/header.php';
    require APP . 'view/users/register.php';
    require APP . 'view/_templates/footer.php';
  }

  /**
   * ACTION: .../users/logout
   * destroy session info, redirects to home
   *
   * @return void
   * @author Christopher Kang
   */
  public function logout() {
    $this->destroy_session_and_data();
    header("Location: /VirusTester/home");
    exit();
  }

  /**
    * Function validate_username
    *
    * Take in form field, Checks for contents, length, and characters
    * @param  string   $field   form field provided by POST request
    * @return string            "" if valid, error if not
    * @author Christopher Kang
    */
  private function validate_username($field) {
    if ($field == "")
      return "Username cannot be blank.\n";
    else if (strlen($field) < 5)
      return "Username must be at least 5 characters long.\n";
    else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
      return "Only a-z, A-Z, 0-9, - and _ allowed in Username.\n";
    return "";
  }

  /**
    * Function validate_email
    *
    * Take in form field Checks for contents, valid email
    * @param  string   $field   form field provided by POST request
    * @return string            "" if valid, error if not
    * @author Christopher Kang
    */
  private function validate_email ($field) {
    if ($field == "")
      return "Email cannot be blank.\n";
    else if ( !((strpos($field, ".")>0 ) && (strpos($field, "@")>0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field) )
      return "Invalid Email Address.\n";
    return "";
  }

  /**
    * Function validate_password
    *
    * Take in form field Checks for contents, length
    * @param  string   $field   form field provided by POST request
    * @return string            "" if valid, error if not
    * @author Christopher Kang
    */
  private function validate_password ($field) {
    if ($field == "") return "Password cannot be blank.\n";
    else if (strlen($field) < 8)
      return "Password must be at least 8 characters long.\n";
    return "";
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
