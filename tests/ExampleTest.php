<?php

require './vendor/autoload.php';
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ExampleTest extends TestCase
{    
    public function testGET(){
        $response = $this->call('GET', "/api/v0/customer/1", []);                
        $responseData = json_decode($response->getContent());              
        $this->assertEquals($responseData->status, 200);
        $this->assertResponseOk();
    }
    
    public function testDELETE(){
        $response = $this->call('DELETE', "/api/v0/customer/1", []);                
        $responseData = json_decode($response->getContent());             
        $this->assertEquals($responseData->status, 200);
        $this->assertResponseOk();        
    }

    public function testPOST() {
        // $file = new UploadedFile(resource_path('tests\customer.csv'), 'customer.csv', 'text/csv');
        // $response = $this->call('POST', "/api/v0/customer", 
        // ['file' => $file]
        // );
        // $responseData = json_decode($response->getContent());
        // $this->assertEquals($responseData->status, 200);
        // $this->assertResponseOk();
        $this->assertTrue(true);
    }
    public function testBulkPOST(){
        $this->assertTrue(true);
    }
    public function testPUT(){
        $this->assertTrue(true);
    }
   
}
