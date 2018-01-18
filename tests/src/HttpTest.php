<?php

use PHPUnit\Framework\TestCase;
use RestfulService\Http;

class HttpTest extends TestCase {

   public function providerPost() {
      return array(
         array('http://www.marceloweb.info/tests/http.php',array('Content-type: application/text'),array('whoareyou'=>'testing'))
      );
   }

   /**
    * @dataProvider providerPost 
    */
   public function testPost($endpoint,$headers,$fields) {
      $result = Http::post($endpoint,$headers,$fields); 
      
      $this->assertEquals($result,'fine');

   }
}
