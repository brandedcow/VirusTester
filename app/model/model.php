<?php
class Model
{
    /**
     * @param object $db A database connection
     */
    function __construct($db)
    {
        if ($db->connect_error) {
          exit('Database connection could not be established.');
        } else {
          $this->db = $db;
          $this->dbSetup();
        }
    }
    private function dbSetup() {
      if ($this->db->ping()) {
        $stmt = $this->db->escape_string("CREATE DATABASE IF NOT EXISTS VirusTester");
        $this->db->query($stmt);
        $stmt2 = $this->db->escape_string("CREATE TABLE IF NOT EXISTS VirusTester.users (id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255) NOT NULL UNIQUE, email VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL, admin BOOLEAN DEFAULT 0 )");
        $this->db->query($stmt2);
        $stmt3 = $this->db->escape_string("CREATE TABLE IF NOT EXISTS VirusTester.viruses (id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, signature VARCHAR(255) NOT NULL UNIQUE)");
        $this->db->query($stmt3);
        $stmt4 = $this->db->prepare("INSERT INTO VirusTester.users (`id`, `username`, `email`, `password`, `admin`) VALUES ('1', 'admin', 'admin@admin.com','18f6edc758d5e5df072ea451139363d8','1')");
        $stmt4->execute();
      }
    }

    /**
     * adds user to database
     *
     * @param  string    $username    username input
     * @param  string    $email       email input
     * @param  string    $password    password input
     * @var    object    $stmt        prepared statement object
     * @var    string    $u           username param
     * @var    string    $e           email param
     * @var    string    $p           password param
     * @return void
     * @author Christopher Kang
     */
    public function addUser($username, $email, $password) {
      if ($this->db->ping()) {
        $password = hash('ripemd128', SALTSTRING . $password);
        $stmt = $this->db->prepare("INSERT INTO VirusTester.users(username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss',$u, $e, $p);
        $u = $username;
        $e = $email;
        $p = $password;
        $result = $stmt->execute();
        if ($result === false) {
          return "Error: ". htmlspecialchars($stmt->error);
        }
        $stmt->close();
      } else {
        return "Error: " . $this->db->error;
      }
    }

    /**
     * checks if user is in database
     *
     * @param  string    $username    username input
     * @param  string    $password    password input
     * @var    object    $stmt        prepared statement object
     * @var    string    $u           username param
     * @var    string    $p           password param
     * @return integer   $result      integer representing user if found
     * @author Christopher Kang
     */
    public function authUser($username, $password) {
      if ($this->db->ping()) {
        $password = hash('ripemd128', SALTSTRING . $password);
        $stmt = $this->db->prepare("SELECT ID FROM VirusTester.USERS WHERE username=? AND password=?");
        $stmt->bind_param('ss', $u, $p);
        $u = $username;
        $p = $password;
        $rc = $stmt->execute();
        if ($rc === false) {
          return "Error: ". htmlspecialchars($stmt->error);
        } else {
          $stmt->store_result();
          $stmt->bind_result($result);
          $stmt->fetch();
          $stmt->free_result();
          $stmt->close();
          return $result;
        }

      } else {
        return "Error: " . $this->db->error;
      }
    }

    /**
     * insert virus sig to database
     *
     * @param  string    $name        virus name input
     * @param  string    $signature   virus sig input
     * @var    object    $stmt        prepared statement object
     * @var    string    $u           name param
     * @var    string    $p           sig param
     * @return void
     * @author Christopher Kang
     */
    public function addVirus($name, $signature) {
      if ($this->db->ping()) {
        $stmt = $this->db->prepare("INSERT INTO VirusTester.viruses(name, signature) VALUES (?, ?)");
        $stmt->bind_param('ss', $n, $s);
        $n = $name;
        $s = $signature;
        $rc = $stmt->execute();
        if ($rc === false) {
          return "Error: ". htmlspecialchars($stmt->error);
        }
        $stmt->close();
      } else {
        return "Error: " . $this->db->error;
      }
    }
    /**
     * insert virus sig to database
     *
     * @param  array     $fileByteArr  file byte representation
     * @var    object    $stmt         prepared statement object
     * @var    integer   $found        index of virus index match
     * @return array     $resultArr    array of virus and matched index
     * @author Christopher Kang
     */
    public function checkVirus($fileByteArr) {
      if ($this->db->ping()) {
        $resultArr = array();
        $stmt = $this->db->prepare("SELECT NAME, SIGNATURE FROM VirusTester.viruses");
        $rc = $stmt->execute();
        if ($rc === false) {
          return "Error: ". htmlspecialchars($stmt->error);
        }
        $stmt->bind_result($vname, $vsignature);
        while ($stmt->fetch()) {
          $found = stripos($fileByteArr, $vsignature);
          if ($found !== false) {
            $resultArr[$vname] = $found;
          }
        }
        $stmt->close();
        return $resultArr;
      } else {
        return null;
      }
    }


}
?>
