<?php
require('./app/core/controller.php');
require('./app/controller/users.php');

class usersTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testUsernameValidation() {
      $input = "";
      $this->expectOutputString("Username cannot be blank.\n");
      Users::validate_username($input);

      $input = "asdf";
      $this->expectOutputString("Username must be at least 5 characters long.\n");
      Users::validate_username($input);

      $input = "..";
      $this->expectOutputString("Only a-z, A-Z, 0-9 allowed in Username.\n");
      Users::validate_username($input);

      $input = "pancakeman";
      $this->expectOutputString("");
      Users::validate_username($input);
    }

    public function testEmailValidation() {
      $input = "";
      $this->expectOutputString("Email cannot be blank.\n");
      Users::validate_email($input);

      $input = "..";
      $this->expectOutputString("Invalid Email Address.\n");
      Users::validate_email($input);

      $input = "chris@pancake.com";
      $this->expectOutputString("");
      Users::validate_email($input);
    }

    public function testPasswordValidation() {
      $input = "";
      $this->expectOutputString("Password cannot be blank.\n");
      Users::validate_password($input);

      $input = "..";
      $this->expectOutputString("Password must be at least 8 characters long.\n");
      Users::validate_password($input);

      $input = "password";
      $this->expectOutputString("");
      Users::validate_password($input);
    }
}
