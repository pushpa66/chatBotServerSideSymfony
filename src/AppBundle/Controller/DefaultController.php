<?php

namespace AppBundle\Controller;

use AppBundle\Structs\FbBot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $token = $request->get('hub_verify_token');
        $hubVerifyToken = '1234';
        if ($token == $hubVerifyToken){
            $challenge = $request->get('hub_challenge');
            echo $challenge;
        } else {
            echo "Token not verified";
        }


//        $input = json_decode(file_get_contents('php://input'), true);
//
//        if(!empty($input['entry'][0]['messaging'][0]['message'])){
//            if($input) {
//                $bot = new FbBot();
//                $bot->setaccessToken($accessToken);
//                $recipient = "1699750453417285";
//                $message = "hello";
//                $bot->sendMessage($recipient,$message);
//            }
//        }
//
        return new Response('');
    }

    /**
     * @Route("/api/test", name="test")
     */
    public function test(Request $request){


        $jsonList = array();
        $jsonList['recipient'] = array('id' => '1699750453417285');
        $jsonList['message']['attachment'] = array("type" => "template");
        $jsonList['message']['attachment']['payload'] = array("template_type" => "generic", 'elements' => array());

        $jsonList['message']['attachment']['payload']['elements'][0] = array('title' => 'Title', 'image_url' => "https://images-na.ssl-images-amazon.com/images/I/", 'subtitle' => '$ 10', 'buttons' => array());
//        $jsonList['message']['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'web_url', 'url' => 'https://www.amazon.com', 'title' => 'View');
//        $jsonList['message']['attachment']['payload']['elements'][0]['buttons'][1] = array('type' => 'json_plugin_url', 'url' => 'https://www.amazon.com', 'title' => 'Track');
        $jsonList['message']['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'web_url', 'url' => 'https://www.amazon.com', 'title' => 'View');
        $jsonList['message']['attachment']['payload']['elements'][0]['buttons'][1] = array('type' => 'postback', 'title' => 'Remove', 'payload' => '');

        $accessToken = 'EAAEZChN9WqTYBALwFF6VLYSoqbYB45TzVjMm4TNk8ArI9sgdeqlrckWKTZBtdRipxZCy0gLTiGZCo1mowZCDehmD3rRBbcwSivHJvvxEzfspRVnXQFccpnqLevUbjdOMBYPlZCI44ZCXNLh6ukTJ5YuVz5TfDxmi5PS9sosCGumTZA6lIoBTEjq0';
        $bot = new FbBot();
        $bot->setaccessToken($accessToken);
        $bot->sendMessageJson($jsonList);
        return new JsonResponse("");
    }
}
