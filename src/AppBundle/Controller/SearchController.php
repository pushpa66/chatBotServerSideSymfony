<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SearchController extends Controller
{
    /**
     * @Route("/api/search", name="search")
     */
    public function searchProducts(Request $request)
    {

        $term = $request->get('term');

//        $message = array();
//        $message['messages'] = array();
//        $message['messages'][] = array('text'=>$term);
//        return new JsonResponse($message);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://api.keepa.com/search?key=bmccnl2m5292v3soegcl3abtfe8cd8dbbpg1r7oddnuirodk9h2imk8djkbht4lk&domain=1&type=product&term=$term",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
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

            $jsonList = array();
            $jsonList['messages'] = array();
            $jsonList['messages'][0]['attachment'] = array("type"=>"template");
            $jsonList['messages'][0]['attachment']['payload'] = array("template_type"=>"list","top_element_style"=>"compact",'elements'=>array());

            for($index = 0; $index < 3; $index++) {

                $productTitle = $response['products'][$index]['title'];
                $asin = $response['products'][0]['asin'];
                $url = "https://www.amazon.com/dp/$asin";
                $csvCount = sizeof($response['products'][$index]['csv'][1]);
                $priceTemp = $response['products'][$index]['csv'][1][$csvCount - 1];
                if($priceTemp == -1){
                    $price = 'not given';
                } else{
                    $price = floatval($priceTemp) / 100;
                }

                $imagesArray = preg_split("/,/", $response['products'][$index]['imagesCSV']);

                $jsonList['messages'][0]['attachment']['payload']['elements'][$index] = array('title'=>''.$productTitle, 'image_url'=>"https://images-na.ssl-images-amazon.com/images/I/$imagesArray[0]", 'subtitle'=>'$ '.$price, 'buttons'=>array());
                $jsonList['messages'][0]['attachment']['payload']['elements'][$index]['buttons'][0] = array('type'=>'web_url','url'=>''.$url,'title'=>'View Item');
            }

            return new JsonResponse($jsonList);
        }

        return new JsonResponse("{}");
    }
}
