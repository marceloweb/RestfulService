<?php

use PHPUnit\Framework\TestCase;
use RestfulService\Http;

class HttpTest extends TestCase {

   public function providerPost() {
      return array(
         array('http://www.marceloweb.info/tests/http.php',array(''),array('whoiam'=>'phpunit'))
      );
   }

   public function providerGet() {
      return array(
	  array('http://www.marceloweb.info/tests/http.php',array(''))
      );
   }

   /**
    * @dataProvider providerPost 
    */
   public function testPost($endpoint,$headers,$fields) {
      $result = Http::post($endpoint,$headers,$fields); 
      
      $this->assertEquals($result,'success');

   }

   public function testPut() {

   }

   /**
    * @dataProvider providerGet
    */
   public function testGet($endpoint,$headers) {
       $result = Http::get($endpoint,$headers);
      
       $this->assertEquals($result,'fail');
   }

   public function testDelete() {

   }

   public function testJson() {

   }

   public function testParseHeaders() {

   }

   public function testGetHeaderCode() {

   }
}
