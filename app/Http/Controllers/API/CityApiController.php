<?php

namespace App\Http\Controllers\API;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Permission;
use App\Models\PermissionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class CityApiController extends Controller
{
    public function index(){
        $cities = City::orderBy('id','DESC')->get();
        return CommonHelper::responseWithData($cities);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(),[
            'latitude' => 'required',
            'longitude' => 'required',
            'name' => 'required|unique:cities',
            'formatted_address' => 'required',
            'time_to_travel' => 'required',
            'max_deliverable_distance' => 'required',
            'delivery_charge_method' => 'required',
            'fixed_charge' => ($request->delivery_charge_method === 'fixed_charge')? 'required':'',
            'per_km_charge' => ($request->delivery_charge_method === 'per_km_charge')? 'required':'',
            'range_wise_charges' => ($request->delivery_charge_method === 'range_wise_charges')? 'required':''
        ],[
            'name.unique' => 'The :attribute has already been taken.',
        ],['name' => 'city name']);
        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first());
        }
        $city = new City();
        $city->latitude = $request->latitude;
        $city->longitude = $request->longitude;
        $city->name = $request->name;
        $city->state = $request->state;
        $city->formatted_address = $request->formatted_address;
        $city->time_to_travel = $request->time_to_travel;
        $city->min_amount_for_free_delivery = $request->min_amount_for_free_delivery;
        $city->max_deliverable_distance = $request->max_deliverable_distance;
        $city->delivery_charge_method = $request->delivery_charge_method;
        $city->fixed_charge = ($request->fixed_charge)??0;
        $city->per_km_charge = ($request->per_km_charge)??0;
        $city->range_wise_charges = $request->range_wise_charges;
        $city->save();
        return CommonHelper::responseSuccess("City Saved Successfully!");
    }
    public function edit($id){
        $city = City::where('id',$id)->first();
        return CommonHelper::responseWithData($city);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'latitude' => 'required',
            'longitude' => 'required',
            'name' =>[ 'required',
                Rule::unique('cities')->where(function($query) use ($request) {
                    $query->where('id', '!=', $request->id);
                })
            ],
            'time_to_travel' => 'required',
            'max_deliverable_distance' => 'required',
            'delivery_charge_method' => 'required',
            'fixed_charge' => ($request->delivery_charge_method === 'fixed_charge')? 'required':'',
            'per_km_charge' => ($request->delivery_charge_method === 'per_km_charge')? 'required':'',
            'range_wise_charges' => ($request->delivery_charge_method === 'range_wise_charges')? 'required':''
        ],[
            'name.unique' => 'The :attribute has already been taken.',
        ],['name' => 'city name']);
        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first());
        }
        $city = City::find($request->id);
        $city->latitude = $request->latitude;
        $city->longitude = $request->longitude;
        $city->name = $request->name;
        $city->state = $request->state;
        $city->formatted_address = $request->formatted_address;
        $city->time_to_travel = $request->time_to_travel;
        $city->min_amount_for_free_delivery = $request->min_amount_for_free_delivery;
        $city->max_deliverable_distance = $request->max_deliverable_distance;
        $city->delivery_charge_method = $request->delivery_charge_method;
        $city->fixed_charge = ($request->fixed_charge)?$request->fixed_charge:0;
        $city->per_km_charge = ($request->per_km_charge)?$request->per_km_charge:0;
        $city->range_wise_charges = $request->range_wise_charges;
        $city->save();
        return CommonHelper::responseSuccess("City Updated Successfully!");
    }

    public function save_boundary(Request $request){
        $validator = Validator::make($request->all(),[
            'geolocation_type' => 'required',
            'boundary_points' => 'required',
        ]);
        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first());
        }
        $city = City::find($request->id);
        $city->geolocation_type = $request->geolocation_type;
        $city->radius = $request->radius;
        $city->boundary_points = $request->boundary_points;
        $city->save();
        return CommonHelper::responseSuccess("City Updated Successfully!");
    }

    public function delete(Request $request){
        if(isset($request->id)){
            $role = City::find($request->id);
            if($role){
                $role->delete();
                return CommonHelper::responseSuccess("City Deleted Successfully!");
            }else{
                return CommonHelper::responseSuccess("City Already Deleted!");
            }
        }
    }
}
