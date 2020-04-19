<?php

use PHPUnit\Framework\TestCase;
use RestfulService\Http;
use RestfulService\tests\Mocks;

class HttpTest extends TestCase {

   public function providerPost() {
      return array(
         array(Mocks::mockPost(1,''),array(''),array('whoiam'=>'phpunit'))
      );
   }

   public function providerGet() {
      return array(
	  array('/tests/http.php?whoiam=phpunit',array(''))
      );
   }

   /**
    * @dataProvider providerPost 
    */
   public function testPost($endpoint,$headers,$fields) {
      $result = Http::post($endpoint,$headers,$fields); 
print_r($result);      
      $this->assertEquals($result,'success');

   }

   /**
    * @dataProvider providerPost
    */
   public function testPut($endpoint,$headers,$fields) {
	$result = Http::put($endpoint,$headers,$fields);

	$this->assertEquals($result,'put or delete');
   }

   /**
    * @dataProvider providerGet
    */
   public function testGet($endpoint,$headers) {
       $result = Http::get($endpoint,$headers);
      
       $this->assertEquals($result,'success');
   }

}
