<?php

require './vendor/autoload.php';
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ExampleTest extends TestCase
{      
    protected $cus_id;
    public function setUp(): void
    {
        parent::setUp();
        $this->cus_id=1;
    }

    // Test Insert the Customer information
    public function testPOST() {         
        $path = storage_path('/app/customer.csv');  
        $original_name = 'customer.csv';  
        $mime_type = 'text/csv';  
        $size = 2476;          
        $test = true;
       
        $file = new UploadedFile($path, $original_name, $mime_type, $size, $test);
       
        $response = $this->call('POST', '/api/v0/customer', [], [], ['file' => $file], []);
        $resp_data = json_decode($response->getContent());        
        // $this->cus_id = $resp_data->data;        
        $this->assertEquals($response->status(), 200);        
        $this->assertResponseOk();                
    }    

    // Test Update the customer information
    public function testPUT(): void {        
        $path = storage_path('/app/customer.csv');  
        $original_name = 'customer.csv';  
        $mime_type = 'text/csv';  
        $size = 2476;          
        $test = true;   

        $file = new UploadedFile($path, $original_name, $mime_type, $size, $test);    

        $response = $this->call('PUT', '/api/v0/customer', ['id' => $this->cus_id], [], ['file' => $file], []);        
        $this->assertEquals($response->status(), 200);        
        $this->assertResponseOk();  
    }

    // Test Insert multiple customer information
    public function testBulkPOST(){
        $path = storage_path('/app/customers.csv');  
        $original_name = 'customers.csv';  
        $mime_type = 'text/csv';  
        $size = 2476;          
        $test = true;
       
        $file = new UploadedFile($path, $original_name, $mime_type, $size, $test);
       
        $response = $this->call('POST', '/api/v0/allcustomer', [], [], ['file' => $file], []);                
        $this->assertEquals($response->status(), 200);        
        $this->assertResponseOk();  
    }     
    
    // Test Get customer information
    public function testGET(): void{                
        $response = $this->call('GET', "/api/v0/customer", ['id' => $this->cus_id], [], [], []);                                             
        $this->assertEquals($response->status(), 200);
        $this->assertResponseOk();             
    }

    // Test Delete customer information
    public function testDELETE(): void {        
        $response = $this->call('DELETE', "/api/v0/customer", ['id' => $this->cus_id], [], [], []);                                   
        $this->assertEquals($response->status(), 200);
        $this->assertResponseOk();             
    }      
   
}
