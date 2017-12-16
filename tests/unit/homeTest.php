<?php
require('./app/core/controller.php');
require('./app/controller/home.php');


class homeTest extends \Codeception\Test\Unit
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
    public function testFileValidation() {
      $sample = array(
        'file1' => array(
                'name' => 'MyFile.txt',
                'type' => 'text/plain',
                'tmp_name' => '/tmp/php/php1h4j1o',
                'error' => UPLOAD_ERR_EXTENSION,
                'size' => 123
            ),
        'file3' => array(
                'name' => 'MyFile.txt',
                'type' => 'text/plain',
                'tmp_name' => '/tmp/php/php6hst32',
                'error' => 0,
                'size' => 9817423
            ),
      );
      $test = Home::validateFile($sample['file1']);
      $this->assertFalse($test);

      $test = Home::validateFile($sample['file3']);
      $this->assertFalse($test);
    }

    public function testNameValidation() {
      $input = "";
      $this->expectOutputString("Virus Name cannot be blank.\n");
      Home::validate_name($input);

      $input = "..";
      $this->expectOutputString("Only a-z, A-Z, 0-9 allowed in Virus Name.\n");
      Home::validate_name($input);

      $input = "Trojan";
      $this->expectOutputString("");
      Home::validate_name($input);
    }
}
