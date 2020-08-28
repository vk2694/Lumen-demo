<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Exception; 
Use Input;
use Illuminate\Support\Facades\Storage;
use Upload;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\Input as InputInput;
use Symfony\Component\Process\ExecutableFinder;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function insertCustomer(Request $request) {           
        try {
            $file = $request->file('file');                          
            $filename = File::get($file);
            $data = explode(',', $filename);
            $cus_id = DB::table('customer')->insertGetId([
                        'first_name' => $data[0],
                        'surename' => $data[1],
                        'age' => $data[2],
                        'mobile' => $data[3],
                        'email' => $data[4],
                    ]);
            return response()->json(['data' => $cus_id, 'status' => 200]);
        } catch (Exception $error) {            
            return $error;
        }    
    }

    public function updateCustomer(Request $request) {
        try {
            $id = $request->input('id');
            $file = $request->file('file');                          
            $filename = File::get($file);
            $data = explode(',', $filename);
            DB::table('customer')->where('id', '=', $id)->update([
                        'first_name' => $data[0],
                        'surename' => $data[1],
                        'age' => $data[2],
                        'mobile' => $data[3],
                        'email' => $data[4],
                    ]);
            return response()->json(['data' => 'Updated Successfully', 'status' => 200]);  
        } catch (Exception $error) {            
            return $error;
        }                      
    }

    public function bulkCustomerUpload(Request $request) {
        try {
            $file = $request->file('file');                          
            $filename = File::get($file);                      
            $data_arr = preg_split('/\r\n|\r|\n/', $filename);
            array_shift($data_arr);
            array_pop($data_arr); 
            foreach($data_arr as $data) {
                $cus_arr = explode(',', $data);
                DB::table('customer')->insert([
                    'first_name' => $cus_arr[0],
                    'surename' => $cus_arr[1],
                    'age' => $cus_arr[2],
                    'mobile' => $cus_arr[3],
                    'email' => $cus_arr[4]
                ]);
            }
            return response()->json(['data' => 'Bulk customer data inserted', 'status' => 200]);    
        } catch (Exception $error) {
            return $error;
        }                                       
    }

    public function getCustomer(Request $request) {  
        $id = $request->input('id');      
        $customer_exists = DB::table('customer')->where('id', '=', $id)->exists();
        if ($customer_exists) {
            try {
                $customer = DB::table('customer')->where('id', '=', $id)->get();
                return response()->json(['data' => $customer, 'status' => 200]);
            } catch (Exception $error) {
                return $error;
            }            
        }
    }

    public function deleteCustomer(Request $request) { 
        $id = $request->input('id');              
        try {
            DB::table('customer')->where('id', '=', $id)->delete();
            return response()->json(['data' => 'Deleted Successfully', 'status' => 200]);
        } catch (Exception $error) {
            return $error;
        }                              
    }    
}
