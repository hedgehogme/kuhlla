<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helpers\CommonHelper;
use App\Helpers\ProductHelper;
use App\Http\Controllers\Controller;
use App\Http\Repository\CategoryRepository;
use App\Http\Repository\ProductRepository;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductVariant;
use App\Models\Seller;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function App\Models\Setting;

class CartApiController extends Controller
{
    public function getUserCart(Request $request){

        $ready_to_add = false;
        $type = $request->get('type','');
        $address_id = $request->get('address_id','');
        $shipping_type = (Setting::get_value('local_shipping') == 1) ? 'local' : 'standard';
        $user_id = auth()->user()->id;

        if(ProductHelper::isItemAvailableInUserCart($user_id)){
            $i = 0;
            $j = 0;
            $x = 0;

            if ($shipping_type == 'standard') {

                $total_amount = 0;
                $sql = "SELECT count(carts.id) as total from carts left join products p on carts.product_id=p.id where p.standard_shipping=1 and carts.save_for_later = 0 AND user_id=" . $user_id;
                $total = \DB::select(\DB::raw($sql));

                $sql = "SELECT carts.*  from carts left join products p on carts.product_id=p.id where p.standard_shipping=1 and carts.save_for_later = 0 AND user_id=" . $user_id . " ORDER BY created_at DESC ";
                $res = \DB::select(\DB::raw($sql));
                //dd($sql);

                $sql = "SELECT carts.qty,carts.product_variant_id from carts left join products p on carts.product_id=p.id where p.standard_shipping=1 and carts.save_for_later = 0 and user_id=" . $user_id;
                $res_1 =  \DB::select(\DB::raw($sql));
                foreach ($res_1 as $row_1) {

                    $sql = "select price,discounted_price from product_variants where id=" . $row_1->product_variant_id;
                    $result_1 = \DB::select(\DB::raw($sql));
                    $taxed_amout = ProductHelper::getTaxableAmount($row_1->product_variant_id);
                    /*foreach ($result_1 as $result_2) {
                        $price = $taxed_amout[0]['taxable_amount'] * $row_1['qty'];
                    }*/
                    $price = $taxed_amout->taxable_amount * $row_1->qty;
                    $total_amount += $price;
                    //$save_price += $taxed_amout->price * $row_1->qty;
                    $save_price = $taxed_amout->price * $row_1->qty;
                }
                $result= array();
                foreach ($res as $row) {

                    $sql = "select pv.*,p.seller_id as seller_id,p.name,p.pincodes,p.pickup_location,pv.weight,p.standard_shipping,p.type as d_type,p.cod_allowed,p.slug,p.image,p.other_images,p.total_allowed_quantity,case WHEN t.percentage!=0 then t.percentage ELSE '0' end as tax_percentage,case WHEN t.title!='' then t.title ELSE '' end as tax_title ,pv.measurement,(select short_code from units u where u.id=pv.stock_unit_id) as units,(Select short_code from units su where su.id=pv.stock_unit_id) as stock_unit_name
                            from product_variants pv
                                left join products p on p.id=pv.product_id
                                left join taxes t on t.id=p.tax_id
                            where pv.id=" . $row->product_variant_id  . " GROUP BY pv.id";

                    $res[$i]->item = \DB::select(\DB::raw($sql));

                    if (isset($res[$i]->item) && !empty($res[$i]->item)) {
                        // print_r($res[$i]['item']);
                        for ($k = 0; $k < count($res[$i]->item); $k++) {
                            // here comment code start
                            //$variant_images = str_replace("'", '"', $res[$i]['item'][$k]->images);
                            //$res[$i]['item'][$k]->images = json_decode($variant_images, 1);
                            //$res[$i]['item'][$k]->images = (empty($res[$i]['item'][$k]->images) || !isset($res[$i]['item'][$k]->images) || is_null($res[$i]['item'][$k]->images)) ? [] : $res[$i]['item'][$k]->images;
                            /*for ($j = 0; $j < count($res[$i]['item'][$k]['images']); $j++) {
                                $res[$i]['item'][$k]['images'][$j] = !empty($res[$i]['item'][$k]['images'][$j]) ? asset('storage/'.$res[$i]['item'][$k]['images'][$j]) : [];
                            }*/

                            //$res[$i]->seller_id = $res[$i]['item'][$k]->seller_id;
                            //$standard_shipping = $res[$i]['item'][$k]->standard_shipping;
                            // here comment code end








                            /*if ($standard_shipping == 1) {
                                $pickup_location = $fn->get_data($column = ['pin_code'], "pickup_location='" . $res[$i]['item'][$k]['pickup_location'] . "'", 'pickup_locations');
                                if (($pincode_id != 0) or ($user_pincode)) {
                                    if (!empty($user_pincode)) {
                                        $data = array('pickup_location' => $pickup_location[0]['pin_code'], 'delivery_pincode' => $user_pincode, 'weight' => $res[$i]['item'][$k]['weight'], 'cod' => $res[$i]['item'][$k]['cod_allowed']);
                                        $shiprocket_data = $shiprocket->check_serviceability($data);
                                        if ($shiprocket_data['status'] == 200) {
                                            $shiprocket_data = $fn->shiprocket_recomended_data($shiprocket_data);
                                            $res[$i]['item'][$k]['is_item_deliverable'] = true;
                                        } else {
                                            $res[$i]['item'][$k]['is_item_deliverable'] = false;
                                        }
                                    } else {
                                        $pincodes_data = $fn->get_data($column = ['*'], "id=" . $pincode_id, "pincodes");
                                        $data = array('pickup_location' => $pickup_location[0]['pin_code'], 'delivery_pincode' =>  $pincodes_data[0]['pincode'], 'weight' => $res[$i]['item'][$k]['weight'], 'cod' => $res[$i]['item'][$k]['cod_allowed']);
                                        $shiprocket_data = $shiprocket->check_serviceability($data);
                                        if ($shiprocket_data['status'] == 200) {
                                            $shiprocket_data = $fn->shiprocket_recomended_data($shiprocket_data);
                                            $res[$i]['item'][$k]['is_item_deliverable'] = true;
                                            $user_pincode = $pincodes_data[0]['pincode'];
                                        } else {
                                            $res[$i]['item'][$k]['is_item_deliverable'] = false;
                                        }
                                    }
                                } else if (isset($_POST['pincode']) && !empty($_POST['pincode'])) {
                                    $pickup_location = $fn->get_data($column = ['pin_code'], "pickup_location='" . $res[$i]['item'][$k]['pickup_location'] . "'", 'pickup_locations');
                                    $data = array('pickup_location' => $pickup_location[0]['pin_code'], 'delivery_pincode' => $_POST['pincode'], 'weight' => $res[$i]['item'][$k]['weight'], 'cod' => $res[$i]['item'][$k]['cod_allowed']);

                                    $shiprocket_data = $shiprocket->check_serviceability($data);
                                    if ($shiprocket_data['status'] == 200) {
                                        $shiprocket_data = $fn->shiprocket_recomended_data($shiprocket_data);
                                        $res[$i]['item'][$k]['is_item_deliverable'] = true;
                                        $user_pincode = $_POST['pincode'];
                                    } else {
                                        $res[$i]['item'][$k]['is_item_deliverable'] = false;
                                    }
                                }
                            }*/
                            for ($j = 0; $j < count($res[$i]->item); $j++) {
                                // here comment code start
                                //$res[$i]['item'][$j]->image = !empty($res[$i]['item'][$j]->image) ? asset('storage/'.$res[$i]['item'][$j]->image) : "";
                                //$res[$i]['item'][$j]->size_chart = !empty($res[$i]['item'][$j]->size_chart) ? asset('storage/'.$res[$i]['item'][$j]->size_chart) : "";
                                if (!empty($passed_pincode_id)) {
                                    //$res[$i]['item'][$j]['delivery_charge'] = $fn->get_item_wise_delivery_charge($row['product_variant_id'],$passed_pincode_id);
                                    // here comment code end
                                }
                            }
                            // $i++;
                        }
                        $i++;
                    }

                    $sql = "select * from carts where save_for_later = 1 AND user_id=" . $user_id . " ORDER BY created_at DESC ";
                    $result = \DB::select(\DB::raw($sql));

                    $sql = "select qty,product_variant_id from carts where save_for_later = 1 AND user_id=" . $user_id;
                    $res1 = \DB::select(\DB::raw($sql));

                    foreach ($res1 as $row1) {
                        $sql = "select price,discounted_price from product_variants where id=" . $row1->product_variant_id;
                        $result1 = \DB::select(\DB::raw($sql));
                        /*foreach ($result1 as $result2) {
                            $price = $result2['discounted_price'] == 0 ? $result2['price'] * $row_1['qty'] : $result2['discounted_price'] * $row1['qty'];
                        }*/
                        $price = $result1->discounted_price == 0 ? $result1->price * $row_1->qty : $result1->discounted_price * $row1->qty;

                    }
                }

                foreach ($result as $rows) {
                    $sql = "select pv.*,p.name,p.type as d_type,p.cod_allowed,p.slug,p.image,p.other_images,case WHEN t.percentage!=null then t.percentage ELSE 0 end as tax_percentage,t.title as tax_title,pv.measurement,(select short_code from units u where u.id=pv.stock_unit_id) as units from product_variants pv left join products p on p.id=pv.product_id left join taxes t on t.id=p.tax_id where pv.id=" . $rows->product_variant_id . " GROUP BY pv.id";
                    $result[$x]['item'] = \DB::select(\DB::raw($sql));
                    for ($z = 0; $z < count($result[$x]['item']); $z++) {

                        $variant_images = str_replace("'", '"', $result[$x]['item'][$z]['images']);
                        $result[$x]['item'][$z]['images'] = json_decode($variant_images, 1);
                        $result[$x]['item'][$z]['images'] = (empty($result[$x]['item'][$z]['images'])) ? array() : $result[$x]['item'][$z]['images'];

                        for ($j = 0; $j < count($result[$x]['item'][$z]['images']); $j++) {
                            $result[$x]['item'][$z]['images'][$j] = !empty($result[$x]['item'][$z]['images'][$j]) ?  asset('storage/'.$result[$x]['item'][$z]['images'][$j]) : "";
                        }
                        $result[$x]['item'][$z]->is_item_deliverable = '';
                        $result[$x]['item'][$z]->is_item_deliverable = '';
                        $result[$x]['item'][$z]->other_images = json_decode($result[$x]['item'][$z]->other_images);
                        $result[$x]['item'][$z]->other_images = empty($result[$x]['item'][$z]->other_images) ? array() : $result[$x]['item'][$z]->other_images;

                        $result[$x]['item'][$z]->tax_percentage = (!empty($result[$x]['item'][$z]->tax_percentage) && $result[$x]['item'][$z]->tax_percentage != "") ? $result[$x]['item'][$z]->tax_percentage  : "0";
                        // $result[$x]['item'][$z]['is_cod_allowed'] = empty($result[$x]['item'][$z]['cod_allowed']) ? "0" : $result[$x]['item'][$z]['cod_allowed'];
                        $result[$x]['item'][$z]->tax_title = empty($result[$x]['item'][$z]->tax_title) ? "" : $result[$x]['item'][$z]->tax_title;

                        if ($result[$x]['item'][$z]['stock'] <= 0 || $result[$x]['item'][$z]->status == 0) {
                            $result[$x]['item'][$z]['isAvailable'] = false;
                            $ready_to_add = true;
                        } else {
                            $result[$x]['item'][$z]['isAvailable'] = true;
                        }

                        $otherImages = ProductImages::where('product_id',$result[$x]['item'][$z]['id'])->where('product_variant_id',0)->get();
                        for ($y = 0; $y < count($otherImages); $y++) {
                            $other_images = asset('storage/'.$result[$x]['item'][$z]['other_images'][$y]);
                            $result[$x]['item'][$z]['other_images'][$y] = $other_images;
                        }
                    }
                    for ($j = 0; $j < count($result[$x]['item']); $j++) {
                        $result[$x]['item'][$j]['image'] = !empty($result[$x]['item'][$j]['image']) ? asset('storage/'.$result[$x]['item'][$j]['image']) : "";
                    }
                    $x++;
                }
            } else {
                $total_amount = 0;
                $sql = "SELECT count(carts.id) as total from carts left join products p on carts.product_id=p.id where p.standard_shipping=0 and carts.save_for_later = 0 AND user_id=" . $user_id;
                $total = \DB::select(\DB::raw($sql));

                $sql = "SELECT carts.*  from carts left join products p on carts.product_id=p.id where p.standard_shipping=0 and carts.save_for_later = 0 AND user_id=" . $user_id . " ORDER BY date_created DESC ";
                $res = \DB::select(\DB::raw($sql));

                $sql = "SELECT carts.qty,carts.product_variant_id from carts left join products p on carts.product_id=p.id where p.standard_shipping=0 and carts.save_for_later = 0 and user_id=" . $user_id;
                $res_1 = \DB::select(\DB::raw($sql));
                foreach ($res_1 as $row_1) {
                    $sql = "select price,discounted_price from product_variants where id=" . $row_1->product_variant_id;
                    $result_1 =  \DB::select(\DB::raw($sql));
                    $taxed_amout = ProductHelper::getTaxableAmount($row_1->product_variant_id);
                    foreach ($result_1 as $result_2) {
                        $price = $taxed_amout->taxable_amount * $row_1->qty;
                    }
                    $total_amount += $price;
                    $save_price += $taxed_amout->taxable_amount * $row_1->qty;
                }

                foreach ($res as $row) {
                    $sql = "select pv.*,p.name,p.pincodes,p.type as d_type,p.cod_allowed,p.slug,p.image,p.other_images,p.total_allowed_quantity,case WHEN t.percentage!=0 then t.percentage ELSE '0' end as tax_percentage,case WHEN t.title!='' then t.title ELSE '' end as tax_title ,t.title as tax_title,pv.measurement,(select short_code from units u where u.id=pv.stock_unit_id) as units,(Select short_code from units su where su.id=pv.stock_unit_id) as stock_unit_name from product_variants pv left join products p on p.id=pv.product_id left join taxes t on t.id=p.tax_id  where pv.id=" . $row->product_variant_id . " GROUP BY pv.id";
                    $res[$i]['item'] = \DB::select(\DB::raw($sql));
                    // print_r($res[$i]['item']);
                    for ($k = 0; $k < count($res[$i]['item']); $k++) {
                        // echo "test";
                        /*if (!empty($pincode_id)) {
                            $pincodes = ($res[$i]['item'][$k]['d_type'] == "all") ? "" : $res[$i]['item'][$k]['pincodes'];
                            // print_r($pincodes);
                            $pincodes = explode(',', $pincodes);
                            if ($res[$i]['item'][$k]['d_type'] == "all") {
                                $res[$i]['item'][$k]['is_item_deliverable'] = true;
                            } else if ($res[$i]['item'][$k]['d_type'] == "included") {
                                if (in_array($pincode_id, $pincodes)) {
                                    $res[$i]['item'][$k]['is_item_deliverable']  = true;
                                } else {
                                    $res[$i]['item'][$k]['is_item_deliverable']  = false;
                                }
                            } else if ($res[$i]['item'][$k]['d_type'] == "excluded") {


                                if (in_array($pincode_id, $pincodes)) {
                                    $res[$i]['item'][$k]['is_item_deliverable']  = false;
                                } else {
                                    $res[$i]['item'][$k]['is_item_deliverable']  = true;
                                }
                            }
                        } else {
                            $res[$i]['item'][$k]['is_item_deliverable'] = false;
                        }*/

                        $res[$i]['item'][$k]['is_item_deliverable'] = true;


                        //$variantImages = ProductImages::where('product_id',$row['id'])->where('product_variant_id',$res[$i]['item'][$k]['id'])->get();
                        $variantImages = ProductImages::where('product_variant_id',$res[$i]['item'][$k]['id'])->get();
                        $res[$i]['item'][$k]['images'] = (empty($variantImages)) ? array() : $variantImages;

                        for ($j = 0; $j < count($variantImages); $j++) {
                            $res[$i]['item'][$k]['images'][$j] = !empty($variantImages[$j]) ?  asset('storage/'.$variantImages[$j]) : "";
                        }


                        //$res[$i]['item'][$k]['other_images'] = json_decode($res[$i]['item'][$k]['other_images']);
                        $otherImages = ProductImages::where('product_id',$res[$i]['item'][$k]['id'])->where('product_variant_id',0)->get();
                        $res[$i]['item'][$k]['other_images'] = empty($otherImages) ? array() : $otherImages;
                        for ($l = 0; $l < count($otherImages); $l++) {
                            $other_images = asset('storage/'.$otherImages[$l]);
                            $res[$i]['item'][$k]['other_images'][$l] = $other_images;
                        }

                        $result[$x]['item'][$z]['tax_percentage'] = (empty($result[$x]['item'][$z]['tax_percentage']) or is_null($result[$x]['item'][$z]['tax_percentage'])) ? "0" :  $result[$x]['item'][$z]['tax_percentage'];
                        // $res[$i]['item'][$k]['is_cod_allowed'] = empty($res[$i]['item'][$k]['is_cod_allowed']) ? "0" : $res[$i]['item'][$k]['is_cod_allowed'];
                        $res[$i]['item'][$k]['tax_title'] = empty($res[$i]['item'][$k]['tax_title']) ? "" : $res[$i]['item'][$k]['tax_title'];
                        if ($res[$i]['item'][$k]['stock'] <= 0 || $res[$i]['item'][$k]['statys'] == 0) {
                            $res[$i]['item'][$k]['isAvailable'] = false;
                            $ready_to_add = true;
                        } else {
                            $res[$i]['item'][$k]['isAvailable'] = true;
                        }

                    }
                    for ($j = 0; $j < count($res[$i]['item']); $j++) {
                        $res[$i]['item'][$j]['image'] = !empty($res[$i]['item'][$j]['image']) ?  asset('storage/'.$res[$i]['item'][$j]['image']) : "";
                        $res[$i]['item'][$j]['size_chart'] = !empty($res[$i]['item'][$j]['size_chart']) ? asset('storage/'.$res[$i]['item'][$j]['size_chart']) : "";
                    }
                    $i++;
                }

                $sql = "select * from carts where save_for_later = 1 AND user_id=" . $user_id . " ORDER BY date_created DESC ";
                $result =  \DB::select(\DB::raw($sql));

                $sql = "select qty,product_variant_id from carts where save_for_later = 1 AND user_id=" . $user_id;
                $res1 =  \DB::select(\DB::raw($sql));

                foreach ($res1 as $row_1) {
                    $sql = "select price,discounted_price from product_variants where id=" . $row_1['product_variant_id'];
                    $result_1 =  \DB::select(\DB::raw($sql));
                    $taxed_amout = ProductHelper::getTaxableAmount($row_1['product_variant_id']);
                    foreach ($result_1 as $result_2) {
                        $price = $taxed_amout['taxable_amount'] * $row_1['qty'];
                    }
                }
                foreach ($result as $rows) {
                    $sql = "select pv.*,p.name,p.type as d_type,p.cod_allowed,p.slug,p.image,p.other_images,t.percentage as tax_percentage,t.title as tax_title,pv.measurement,(select short_code from units u where u.id=pv.stock_unit_id) as units from product_variants pv left join products p on p.id=pv.product_id left join taxes t on t.id=p.tax_id where pv.id=" . $rows['product_variant_id'] . " GROUP BY pv.id";
                    $result[$x]['item'] = \DB::select(\DB::raw($sql));

                    for ($z = 0; $z < count($result[$x]['item']); $z++) {
                        $variant_images = str_replace("'", '"', $result[$x]['item'][$z]['images']);
                        $result[$x]['item'][$z]['images'] = json_decode($variant_images, 1);
                        $result[$x]['item'][$z]['images'] = (empty($result[$x]['item'][$z]['images'])) ? array() : $result[$x]['item'][$z]['images'];

                        for ($j = 0; $j < count($result[$x]['item'][$z]['images']); $j++) {
                            $result[$x]['item'][$z]['images'][$j] = !empty($result[$x]['item'][$z]['images'][$j]) ? asset('storage/.' . $result[$x]['item'][$z]['images'][$j]) : "";
                        }

                        $result[$x]['item'][$z]['is_item_deliverable'] = '';
                        $result[$x]['item'][$z]['is_item_deliverable'] = '';
                        $result[$x]['item'][$z]['other_images'] = json_decode($result[$x]['item'][$z]['other_images']);
                        $result[$x]['item'][$z]['other_images'] = empty($result[$x]['item'][$z]['other_images']) ? array() : $result[$x]['item'][$z]['other_images'];
                        $result[$x]['item'][$z]['tax_percentage'] = (empty($result[$x]['item'][$z]['tax_percentage']) or is_null($result[$x]['item'][$z]['tax_percentage'])) ? "0" :  $result[$x]['item'][$z]['tax_percentage'];
                        // $result[$x]['item'][$z]['is_cod_allowed'] = empty($result[$x]['item'][$z]['cod_allowed']) ? "0" : $result[$x]['item'][$z]['cod_allowed'];
                        $result[$x]['item'][$z]['tax_title'] = empty($result[$x]['item'][$z]['tax_title']) ? "" : $result[$x]['item'][$z]['tax_title'];

                        if ($result[$x]['item'][$z]['stock'] <= 0 || $result[$x]['item'][$z]['status'] == 0) {
                            $result[$x]['item'][$z]['isAvailable'] = false;
                            $ready_to_add = true;
                        } else {
                            $result[$x]['item'][$z]['isAvailable'] = true;
                        }

                        for ($y = 0; $y < count($result[$x]['item'][$z]['other_images']); $y++) {
                            $other_images = asset('storage/'.$result[$x]['item'][$z]['other_images'][$y]);
                            $result[$x]['item'][$z]['other_images'][$y] = $other_images;
                        }
                    }
                    for ($j = 0; $j < count($result[$x]['item']); $j++) {
                        $result[$x]['item'][$j]['image'] = !empty($result[$x]['item'][$j]['image']) ? asset('storage/'.$result[$x]['item'][$j]['image']) : "";
                    }
                    $x++;
                }
            }


            /*if ($shipping_type == 'standard') {
                $parcels = $fn->make_shipping_parcels($res);
                $delivery_charge_parcels = $fn->check_parcels_deliveriblity($parcels, $user_pincode, $is_code);
                $delivery_charage_by_item = $delivery_charge_parcels['delivery_charge'];
            } else {
                $check_address = $fn->get_data(['area_id'], "id=$address_id", 'user_addresses');
                if (isset($_POST['address_id']) && !empty($_POST['address_id'])) {
                    if ($check_address[0]['area_id'] == 0) {
                        $response['error'] = true;
                        $response['message'] = "Sorry sir we cannot delivered on this address";
                        print_r(json_encode($response));
                        return false;
                    }
                }

                $delivery_charage_by_item = $fn->get_delivery_charge($address_id, $total_amount);
            }*/

            $delivery_charage_by_item = 0;
            if (!empty($res) || !empty($result)) {
                if (!empty($type) && $type == 'delivery_charge') {
                    $response['delivery_charge'] = "$delivery_charage_by_item";
                } else {
                    $sub_total = $total_amount;
                    $saved_amount =  $save_price -  $total_amount;
                    $total_amount = $total_amount + $delivery_charage_by_item;
                    $response['total'] = $total[0]->total;
                    $response['ready_to_cart'] = $ready_to_add;
                    $response['total_amount'] = "$total_amount";
                    $response['sub_total'] = "$sub_total";
                    $response['saved_amount'] = ($saved_amount <= 0) ? "0" : "$saved_amount";
                    $response['delivery_charge'] = "$delivery_charage_by_item";
                    $response['message'] = 'Cart Data Retrived Successfully!';
                    $response['data'] = array_values($res);
                    $response['save_for_later'] = array_values($result);

                    return CommonHelper::responseWithData($response);
                }
            } else {
                return CommonHelper::responseError("No item(s) found in users cart!");
            }

        }else{
            return CommonHelper::responseError('No item(s) found in user cart!');
        }
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'product_variant_id' => 'required',
            'qty' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return CommonHelper::responseError($validator->errors()->first());
        }

        $product_id = $request->product_id;
        $variant_id = $request->product_variant_id;
        $qty = $request->get('qty', '');
        $user = auth()->user();

        if (ProductHelper::isItemAvailable($product_id, $variant_id)) {

            $variant = ProductVariant::where('id', $variant_id)->first();
            if ($variant) {

                if ($variant->stock > 0 && $variant->status == 1) {

                    if (ProductHelper::isItemAvailableInUserCart($user->id, $variant_id)) {
                        $cart = Cart::where('user_id', $user->id)
                            ->where('product_variant_id', $variant_id)->first();

                        /* if item found in user's cart update it */
                            /*if ($cart) {
                                $cart->qty = $qty;
                                $cart->save();
                                return CommonHelper::responseSuccess('Item updated successfully.');
                            }*/


                        // check for total allowed quantity
                        $total_quantity = Cart::where('user_id', $user->id)
                            ->where('product_id', $product_id)
                            ->where('save_for_later', 0)
                            ->sum('qty');

                        if ($total_quantity) {
                            $total_allowed_quantity = Product::where('id', $product_id)->pluck('total_allowed_quantity')->first();
                            $temp = Cart::where('user_id', $user->id)->where('product_variant_id', $variant_id)->pluck('qty')->first();

                            $total_quantity = $total_quantity - $temp;
                            $total_quantity = $total_quantity + $qty;

                            if ($total_quantity > $total_allowed_quantity) {
                                return CommonHelper::responseSuccess('Total allowed quantity for this product is ' . $total_allowed_quantity . '!');
                            }
                        }

                        if ($cart) {

                            $cart->qty = $qty;
                            $cart->save_for_later = 0;
                            $cart->save();

                            return CommonHelper::responseSuccess('Item updated in users cart successfully');

                        } else {

                            return CommonHelper::responseError('Item not found!');
                        }

                    } else {

                        if ($user->status == 1) {

                            $total_allowed_quantity = Product::where('id', $product_id)->first()->pluck('total_allowed_quantity');
                            if ($total_allowed_quantity && $qty > $total_allowed_quantity) {
                                return CommonHelper::responseSuccess('Total allowed quantity for this product is ' . $total_allowed_quantity . '!');
                            }

                            /* if item not found in user's cart add it */
                            $data = array(
                                'user_id' => $user->id,
                                'product_id' => $product_id,
                                'product_variant_id' => $variant_id,
                                'qty' => $qty
                            );

                            $insert = Cart::insert($data);
                            if ($insert) {
                                return CommonHelper::responseSuccess('Item added to users cart successfully');
                            } else {
                                return CommonHelper::responseError('Something went wrong!');
                            }


                        } else {
                            return CommonHelper::responseError("Not allowed to add to cart as your account is de-activated!");
                        }


                    }

                } else {
                    return CommonHelper::responseError('Opps stock is not available!');
                }
            } else {
                return CommonHelper::responseError('No such item available!');
            }
        }else{
            return CommonHelper::responseError('No such item available!');
        }
    }

    public function removeFromCart(Request $request){

        $user_id = auth()->user()->id;
        $variant_id = $request->get('product_variant_id','');

        if(ProductHelper::isItemAvailableInUserCart($user_id,$variant_id)){

            $cart = Cart::where('user_id',$user_id);
            if(!empty($variant_id)){
                $cart->where('product_variant_id',$variant_id);
                $cart = $cart->get();
                if(count($cart)>0){
                    return CommonHelper::responseSuccess('All items removed from users cart successfully');
                }
            }
            $cart = $cart->first();
            if($cart){
                return CommonHelper::responseSuccess('Item removed from users cart successfully');
            }

        }else{
            return CommonHelper::responseError('Item not found in users cart!');
        }

    }

}
