<?php

namespace App\Http\Controllers\API;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomersApiController extends Controller
{
    public function index(){

        $customers = User::orderBy('id','DESC')->get();
        return CommonHelper::responseWithData($customers);
    }
    public function changeStatus(Request $request){
        if(isset($request->id)){
            $customers = User::find($request->id);
            if($customers){
                $customers->status = ( $customers->status == 1 )?0:1;
                $customers->save();
                return CommonHelper::responseSuccess("Customers Status Updated Successfully!");
            }else{
                return CommonHelper::responseSuccess("Customer Record not found!");
            }
        }
    }
}
