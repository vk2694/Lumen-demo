<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getCustomer($id) {        
        $customer_exists = DB::table('customer')->where('id', '=', $id)->exists();
        if ($customer_exists) {
            $customer = DB::table('customer')->where('id', '=', $id)->get();
            return response()->json(['data' => $customer, 'status' => 200]);
        } else {
            return response()->json(['data' => 'Customer Id does not exists', 'status' => 404]);
        }
    }

    public function insertCustomer(Request $request) {
        $post_data = $request->getContent();                
        $data_space = trim($post_data);
        $split_strings = preg_split('/[\ \n\,]+/', $data_space);                  
        $customer_id = DB::table('customer')->insertGetId([
            'first_name' => $split_strings[0],
            'surename' => $split_strings[1],
            'age' => $split_strings[2],
            'mobile' => $split_strings[3],
            'email' => $split_strings[4],
        ]);
        return $post_data;
        if ($customer_id)
            return response()->json(['data' => $customer_id, 'status' => 200]);
        else
            return response()->json(['data' => 'Customer data not inserted', 'status' => 500]);
    }

    public function updateCustomer(Request $request) {
        $cus_id = $request->get('id');
        $post_data = $request->getContent();
        $data_space = trim($post_data);
        $split_strings = preg_split('/[\ \n\,]+/', $data_space);             
        DB::table('customer')->where('id', '=', $cus_id)->update([
            'first_name' => $split_strings[0],
            'surename' => $split_strings[1],
            'age' => $split_strings[2],
            'mobile' => $split_strings[3],
            'email' => $split_strings[4]
        ]);
        return response()->json(['data' => 'Updated Successfully', 'status' => 200]);    
    }

    public function deleteCustomer($id) {        
        $customer_exists = DB::table('customer')->where('id', '=', $id)->exists();
        if ($customer_exists) {
            DB::table('customer')->where('id', '=', $id)->delete();
            return response()->json(['data' => 'Deleted Successfully', 'status' => 200]);
        } else {            
            return response()->json(['data' => 'Customer Id does not exists', 'status' => 405]);
        }            
    }

    public function bulkCustomerUpload(Request $request) {
        $post_data = $request->getContent();        
        $data_arr = preg_split('/\r\n|\r|\n/', $post_data);
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
    }
}
