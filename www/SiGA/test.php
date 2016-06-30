<?php

class SigaTest extends PHPUnit_Framework_TestCase
{
	private $EXPECTED_RESULT = '0';
	
	private function principalFunction($data)
	{
		$result = shell_exec("php index.php " . $data);
		$myfile = fopen("testfile.html", "w");
		fwrite($myfile, $result);
		fclose($myfile);
		
		$myfilea = fopen("testfile.html", "r");
		
		for($i = 0; $i < 25; $i++) fgets($myfilea);
		
		$variavel =  fgets($myfilea);
		
		fclose($myfilea);
		
		unlink("testfile.html");
		
		$this->assertEquals(intval($variavel),intval($this->EXPECTED_RESULT));
	
	}
	
	public function testStudentRegistration()
	{
		$this->principalFunction("student_registration_test");
	}
	
	public function testDepartment()
	{
		$this->principalFunction("department_test");
	}
}
	
?>
