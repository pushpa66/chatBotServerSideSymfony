<?php

/**
 * Created by PhpStorm.
 * User: shan
 * Date: 2/25/18
 * Time: 2:29 PM
 */
namespace AppBundle\Structs;

use Symfony\Component\Config\Definition\Exception\Exception;

class FbBot
{

    private $hubVerifyToken = null;
    private $accessToken = null;
    protected $client = null;
    function __construct()
    {
    }

    public function setHubVerifyToken($value)
    {
        $this->hubVerifyToken = $value;
    }

    public function setAccessToken($value)
    {
        $this->accessToken = $value;
    }

    public function verifyToken($hub_verify_token, $challenge)
    {
        try {
            if ($hub_verify_token === $this->hubVerifyToken) {
                return $challenge;
            }
            else {
                throw new Exception("Token not verified");
            }
        }

        catch(Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function readMessage($input)
    {
        try {
            $payloads = null;
            $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
            $messageText = $input['entry'][0]['messaging'][0]['message']['text'];
            return ['senderid' => $senderId, 'message' => $messageText];
        }

        catch(Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function sendMessage($recipient,$message)
    {
        $curl = curl_init();
        $response = array();
        $response['recipient']['id'] = $recipient;
        $response['message']['text'] = $message;

        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://graph.facebook.com/v2.6/me/messages?access_token=$this->accessToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($response),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));
        if($recipient != null){
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }

    }

    public function sendMessageJson($message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://graph.facebook.com/v2.6/me/messages?access_token=$this->accessToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($message),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
