<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Twilio\Rest\Client;
use App\Models\User;
use App\Models\Notifications;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Sends sms to user using Twilio's programmable sms client
     * @param String $message Body of sms
     * @param Number $recipients Number of recipient
     */
    public function sendMessage($message, $recipients)
    {
        $account_sid = "AC6fd4a032b2eba7283e7eea43bdde0f04";
        $auth_token = "b3b65c0e756e402f641bf2a6acb85dce";
        $twilio_number = "+18654248826";
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }

    public function storeNotification($userId,$heading,$message,$type){

        $user = User::where('id', $userId)->first();

        if(!empty($user)){
            if (!empty($user->fcm)){
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                "to":"'.$user->fcm.'",
                "data":{
                    "body":"'.$message.'",
                    "title":"'.$heading.'",
                }
            }',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: key=AAAAsr5ckTA:APA91bFQ5ToRx9Lw_BkT1Wxayo1_7r7TEYmkiRzqEA3GcWBSYkcvznKDYTp_9As5vI4Tp-fxM_zTh2lKvGhs8a0Nc7NBH8JQ-eQ8KUu_9G_n7CZJyB-PMKnOfJdq4tVg0gltsOMU-PM6',
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);
                // echo $response;

                curl_close($curl);
            }
            $store = new Notifications();
            $store->user_id = $userId;
            $store->heading = $heading;
            $store->message = $message;
            $store->type = $type;

            $insert = $store->save();
            if($insert){
                return true;
            }
        }
    }
}
