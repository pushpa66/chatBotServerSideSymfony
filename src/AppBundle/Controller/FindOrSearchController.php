<?php

namespace AppBundle\Controller;

use AppBundle\Structs\Configuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FindOrSearchController extends Controller
{

    /**
     * @Route("/api", name="api")
     */
    public function getProductDetailsByASIN(Request $request)
    {
//
//        $asin = "Car";
//        $userID = Configuration::userID;
//        $userFirstName = Configuration::userFirstName;

        $asin = $request->get('asin');
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');
        $startIndex = $request->get('index');

        if(!$startIndex) {
            $startIndex = 0;
        }



//        $message = array();
//        $message['messages'] = array();
//        $message['messages'][] = array('text' => 'Asin '.$userFirstName);
//        return new JsonResponse($message);


        $asin = str_replace(" ","-",$asin);
        $asinCheck = $this->checkASIN($asin);
        if(!$asinCheck) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_URL => "https://api.keepa.com/search?key=".Configuration::keepaAccessToken."&domain=1&type=product&term=$asin",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: 65ecf759-bbaa-534e-eefb-617cfbf7e34f"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response, true);

//            $message = array();
//            $message['messages'] = $response['products'][40];

                $productCount = sizeof($response['products']);
                if ($productCount == 0) {
                    $message = array();
                    $message['messages'] = array();
                    $message['messages'][] = array('text' => 'No products are found for \''.$asin.'.\'');
                    return new JsonResponse($message);
                } else {
                    $jsonList = array();
                    $jsonList['messages'] = array();

                    $index = $startIndex;
                    $maxIndex = $startIndex + 4;

                    if($startIndex == 0){
                        $jsonList['messages'][0] = array('text' => $productCount . ' products are found for \''.$asin.'\'. Please select one of the products or try another search.');

                    } else {
                        $jsonList['messages'][0] = array('text' => 'Another '.($productCount-$startIndex).' products remain.');
                    }
                     $jsonList['messages'][1]['attachment'] = array("type" => "template");
//                    $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());
                    $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "generic","image_aspect_ratio" => "square", 'elements' => array());


                    if ($productCount < $maxIndex) {
                        $maxIndex = $productCount;
                    }

                    for ($i = 0; $i < ($maxIndex - $startIndex); $i++) {

                        $productTitle = $response['products'][$index + $i]['title'];
                        $asinOfProduct = $response['products'][$index + $i]['asin'];
                        $url = "https://www.amazon.com/dp/$asinOfProduct";
                        $csvCount = sizeof($response['products'][$index + $i]['csv'][1]);
                        $priceTemp = $response['products'][$index + $i]['csv'][1][$csvCount - 1];
                        if ($priceTemp == -1) {
                            $price = 'not given';
                        } else {
                            $price = floatval($priceTemp) / 100;
                        }

                        $imagesArray = preg_split("/,/", $response['products'][$index + $i]['imagesCSV']);

                        $jsonList['messages'][1]['attachment']['payload']['elements'][$i] = array('title' => '' . $productTitle, 'image_url' => "https://images-na.ssl-images-amazon.com/images/I/$imagesArray[0]", 'subtitle' => '$ ' . $price, 'buttons' => array());
                        $jsonList['messages'][1]['attachment']['payload']['elements'][$i]['buttons'][0] = array('type' => 'web_url', 'url' => '' . $url, 'title' => 'View');
                        $jsonList['messages'][1]['attachment']['payload']['elements'][$i]['buttons'][1] = array('type' => 'json_plugin_url', 'url' =>  Configuration::trackProductApiUrl.$asinOfProduct.'&id='.$userID.'&userFirstName='.$userFirstName, 'title' => 'Track');
                    }

                    if ($maxIndex != $productCount){
                        $jsonList['messages'][1]['attachment']['payload']['elements'][$maxIndex - $startIndex - 1]['buttons'][2] = array('type' => 'json_plugin_url', 'url' =>  Configuration::findSearchApiUrl.$asin.'&id='.$userID.'&userFirstName='.$userFirstName.'&index='.$maxIndex, 'title' => 'Next');

                    }

                    return new JsonResponse($jsonList);
                }
            }

        } else {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_URL => "https://api.keepa.com/product?key=".Configuration::keepaAccessToken."&domain=1&asin=$asin",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: 65ecf759-bbaa-534e-eefb-617cfbf7e34f"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response, true);

                if ($response['products'][0]){
//                    $message = array();
//                    $message['messages'] = $response['products'][0];

                    $productTitle = $response['products'][0]['title'];
                    $url = "https://www.amazon.com/dp/$asin";


                    $csvCount = sizeof($response['products'][0]['csv'][1]);
                    $priceTemp = $response['products'][0]['csv'][1][$csvCount - 1];
                    if ($priceTemp == -1) {
                        $price = 'not given';
                    } else {
                        $price = floatval($priceTemp) / 100;
                    }

                    $imagesArray = preg_split("/,/", $response['products'][0]['imagesCSV']);

                    $jsonList = array();
                    $jsonList['messages'] = array();
                    $jsonList['messages'] = array();
                    $jsonList['messages'][0] = array('text' => 'This is the product for ASIN : \''.$asin.'.\'');
                    $jsonList['messages'][1]['attachment'] = array("type" => "template");

//                    $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());

                    $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "generic","image_aspect_ratio" => "square", 'elements' => array());
                    $jsonList['messages'][1]['attachment']['payload']['elements'][0] = array('title' => $productTitle, 'image_url' => "https://images-na.ssl-images-amazon.com/images/I/$imagesArray[0]", 'subtitle' => '$ ' . $price, 'buttons' => array());
                    $jsonList['messages'][1]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'web_url', 'url' => $url, 'title' => 'View');
                    $jsonList['messages'][1]['attachment']['payload']['elements'][0]['buttons'][1] = array('type' => 'json_plugin_url', 'url' => Configuration::trackProductApiUrl.$asin.'&id='.$userID.'&userFirstName='.$userFirstName, 'title' => 'Track');
                    return new JsonResponse($jsonList);

                } else {
                    $message = array();
                    $message['messages'] = array();
                    $message['messages'][] = array('text' => 'No products are found for ASIN : \''.$asin.'.\'');
                    return new JsonResponse($message);
                }


//            return new JsonResponse($message);
            }
        }
        return new JsonResponse('{}');
    }

    public function checkASIN($input){
        $maxIndex = strlen($input);

        if($maxIndex == 10){
            for ($i = 0; $i < $maxIndex; $i++) {
                if (!ctype_upper($input[$i])) {
                    if (!is_numeric($input[$i])){
                        return false;
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
