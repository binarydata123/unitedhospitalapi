<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Library\SslCommerz\SslCommerzNotification;
use Log;
use App\Classes\ErrorsClass;

class SslCommerzPaymentApiController extends Controller
{
    public function getSession(Request $request)
    {
        /*$post_data = {
            "store_id": env("STORE_ID"),
            "store_passwd": env("STORE_PASSWORD"),
            "total_amount": $request->input('total_price'),
            "currency": "BDT",
            "tran_id": uniqid(),
            "success_url": "http://localhost/reactjs/unitedhospitalapi/success",
            "fail_url": "http://localhost/reactjs/unitedhospitalapi/fail",
            "cancel_url": "http://localhost/reactjs/unitedhospitalapi/cancel",
            "ipn_url": "http://localhost/reactjs/unitedhospitalapi/ipn",
            "cus_name": $request->input('patient_name'),
            "cus_email": strtolower($request->input('patient_name')).'@gmail.com',
            "cus_add1": "Dhaka",
            "cus_add2": "Dhaka",
            "cus_city": "Dhaka",
            "cus_state": "Dhaka",
            "cus_postcode": "1000",
            "cus_country": "Bangladesh",
            "cus_phone": $request->input('phone_number'),
            "cus_fax": $request->input('phone_number'),
            "ship_name": $request->input('patient_name'),
            "ship_add1": "Dhaka",
            "ship_add2": "Dhaka",
            "ship_city": "Dhaka",
            "ship_state": "Dhaka",
            "ship_postcode": "1000",
            "ship_country": "Bangladesh",
            "multi_card_name": "mastercard,visacard,amexcard",
            "patient_id": $request->input('patient_id'),
            "doctor_name": $request->input('doctor_name'),
            "doctor_id": $request->input('doctor_id'),
            "doctor_fees": $request->input('doctor_fees'),
            "registration_fees": $request->input('registration_fees'),
            "shipping_method": "YES",
            "product_name": "credit",
            "product_category": "general",
            "product_profile": "general",
        }*/
        $post_data = array();
        $post_data['store_id'] = env("STORE_ID");
        $post_data['store_passwd'] = env("STORE_PASSWORD");
        $post_data['total_amount'] = $request->input('total_price'); # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        $post_data['success_url'] = "http://localhost/reactjs/unitedhospitalapi/success";
        $post_data['fail_url'] = "http://localhost/reactjs/unitedhospitalapi/fail";
        $post_data['cancel_url'] = "http://localhost/reactjs/unitedhospitalapi/cancel";
        $post_data['ipn_url'] = "http://localhost/reactjs/unitedhospitalapi/ipn";

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->input('patient_name');
        $post_data['cus_email'] = strtolower($request->input('patient_name')).'@gmail.com';
        //$post_data['cus_email'] = 'patient@mail.com';
        $post_data['cus_add1'] = 'Dhaka';
        $post_data['cus_add2'] = "Dhaka";
        $post_data['cus_city'] = "Dhaka";
        $post_data['cus_state'] = "Dhaka";
        $post_data['cus_postcode'] = "1000";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->input('phone_number');
        $post_data['cus_fax'] = $request->input('phone_number');
        $post_data['ship_name'] = $request->input('patient_name');
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_country'] = "Bangladesh";
        $post_data['multi_card_name'] = "mastercard,visacard,amexcard";
        $post_data['patient_id'] = $request->input('patient_id');
        $post_data['doctor_name'] = $request->input('doctor_name');
        $post_data['doctor_id'] = $request->input('doctor_id');
        $post_data['doctor_fees'] = $request->input('doctor_fees');
        $post_data['registration_fees'] = $request->input('registration_fees');
        $post_data['shipping_method'] = "YES";
        $post_data['product_name'] = "credit";
        $post_data['product_category'] = "general";
        $post_data['product_profile'] = "general";

        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'doctor_id' => $post_data['doctor_id'],
                'patient_id' => $post_data['patient_id'],
                'patient_phone_number' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'doctor_name' => $post_data['doctor_name'],
                'patient_name' => $post_data['cus_name'],
                'doctor_fees' => $post_data['doctor_fees'],
                'registration_fees' => $post_data['registration_fees'],
                'status' => 'Pending',
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);
        $url = 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($curl);
        curl_close($curl);

        print_r($data);
    }

}
