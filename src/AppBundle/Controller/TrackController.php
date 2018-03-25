<?php
/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 3/8/2018
 * Time: 7:09 PM
 */

namespace AppBundle\Controller;

use AppBundle\Structs\Configuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Entity\UserProduct;

use Doctrine\ORM\EntityManagerInterface;

class TrackController extends Controller
{
    /**
     * @Route("/api/track", name="track")
     */
    public function trackProducts(Request $request)
    {
        $productASIN = $request->get('asin');
        $productPrice = $request->get('price');
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');

//        $message = array();
//        $message['messages'] = array();
//        $message['messages'][] = array('text'=>'You have already tracked this product with ASIN : \''.$userID.'\'');
//        return new JsonResponse($message);
        if ($productPrice != "not-given"){
            $checkUser = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(
                    array('userID' => $userID)
                );
            if(!$checkUser){
                $entityManager = $this->getDoctrine()->getManager();
                $user = new User();
                $user->setUserID($userID);
                $user->setUserFirstName($userFirstName);
                $entityManager->persist($user);
                $entityManager->flush();
            }

            $checkTrackingByUser = $this->getDoctrine()
                ->getRepository(UserProduct::class)
                ->findOneBy(
                    array('userID' => $userID, 'productASIN' => $productASIN)
                );
            if(!$checkTrackingByUser){
                $productCheck = $this->getDoctrine()
                    ->getRepository(Product::class)
                    ->findOneBy(
                        array('productASIN' => $productASIN)
                    );
                if(!$productCheck){
                    $entityManager = $this->getDoctrine()->getManager();
                    $product = new Product();
                    $product->setProductASIN($productASIN);
                    $entityManager->persist($product);
                    $entityManager->flush();
                }

                $entityManager = $this->getDoctrine()->getManager();
                $userProduct = new UserProduct();
                $userProduct->setUserID($userID);
                $userProduct->setProductASIN($productASIN);
                $entityManager->persist($userProduct);
                $entityManager->flush();

                $productPrice = $productPrice - $productPrice * 0.05;

                $this->trackThisASIN($productASIN, $productPrice);

                $message = array();
                $message['messages'] = array();
                $message['messages'][] = array('text'=>$userFirstName.', your product with ASIN : \''.$productASIN.'\' is tracked successfully with 5% price reduction (tracked price $ '.$productPrice);
                return new JsonResponse($message);
            } else {

                $productPrice = $productPrice - $productPrice * 0.05;
                $this->trackThisASIN($productASIN, $productPrice);

                $message = array();
                $message['messages'] = array();
                $message['messages'][] = array('text'=>'You have already tracked this product with ASIN : \''.$productASIN.'\'. Update it with price $'.$productPrice);
                return new JsonResponse($message);
            }
        } else {
            $message = array();
            $message['messages'] = array();
            $message['messages'][] = array('text'=>'Sorry!! I can not track this product. Price is not available.');
            return new JsonResponse($message);
        }

    }

    /**
     * @Route("/api/removeTrackedProduct", name="removeTrackedProduct")
     */
    public function removeTrackedProducts(Request $request)
    {
        $productASIN = $request->get('asin');
        $userID = $request->get('id');

        $userProduct = $this->getDoctrine()
            ->getRepository(UserProduct::class)
            ->findOneBy(
                array('userID' => $userID, 'productASIN' => $productASIN)
            );
        if ($userProduct) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProduct);
            $entityManager->flush();
        }

        $otherUserProducts = $this->getDoctrine()
            ->getRepository(UserProduct::class)
            ->findBy(
                array('productASIN' => $productASIN)
            );
        if (!$otherUserProducts) {
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                    ->findoneBy(
                        array('productASIN' => $productASIN)
                    );
            if ($product){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($product);
                $entityManager->flush();
            }

            $this->remove($productASIN);

        }
        $message = array();
        $message['messages'] = array();
        $message['messages'][0] = array("text" => "Product with ASIN ".$productASIN." is removed successfully!");
        return new JsonResponse($message);
    }

    public function trackThisASIN($productASIN, $productPrice){
        $notificationType = array();
        $notificationType[0] = false;
        $notificationType[1] = false;
        $notificationType[2] = false;
        $notificationType[3] = false;
        $notificationType[4] = false;
        $notificationType[5] = true;
        $notificationType[6] = false;
        $notificationType[7] = false;

        $trackingThresholdValue = array();

        $trackingThresholdValue[0] = array(
            "thresholdValue" => $productPrice,
            "domain" =>  1,
            "csvType" => 1,
            "isDrop" => true
        );
        $trackingThresholdValue[1] = array(
            "thresholdValue" => $productPrice,
            "domain" =>  1,
            "csvType" => 1,
            "isDrop" => false
        );

        $trackingNotifyIf = array();
        $trackingNotifyIf[0] = array(
            "domain" => 1,
            "csvType" => 1,
            "notifyIfType" => 0,
        );
        $trackingNotifyIf[1] = array(
            "domain" => 1,
            "csvType" => 1,
            "notifyIfType" => 1,
        );

        $trackData = array(
            "asin" => $productASIN,
            "ttl" => 0,
            "expireNotify" => true,
            "desiredPricesInMainCurrency" => true,
            "mainDomainId" => 1,
            "updateInterval" => 1,
            "thresholdValues" => $trackingThresholdValue,
            "notifyIf" => $trackingNotifyIf,
            'notificationType' => $notificationType,
            "individualNotificationInterval" => -1
//            "individualNotificationInterval" => 1
        );

//        return new JsonResponse($trackData);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://api.keepa.com/tracking?key=".Configuration::keepaAccessToken."&type=add",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($trackData),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 3926067a-03ee-f119-ae37-d7b674ce0507"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

    }

    public function remove($productASIN){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://api.keepa.com/tracking?key=".Configuration::keepaAccessToken."&type=remove&asin=$productASIN",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 3c787ded-16f7-221c-ea82-52b1703a3018"
            ),
        ));

        curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        } else {
            return true;
        }
    }

    public function removeAll(){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://api.keepa.com/tracking?key=".Configuration::keepaAccessToken."&type=removeAll",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: f2cb1303-c489-330a-d858-f025e32e791b"
            ),
        ));

        curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        } else {
            return true;
        }
    }

    /**
     * @Route("/api/trackThisASIN", name="trackThisASIN")
     */
    public function testTrackThisASIN(Request $request){
        $productASIN = $request->get('asin');
        $productPrice = $request->get('price');

        $notificationType = array();
        $notificationType[0] = false;
        $notificationType[1] = false;
        $notificationType[2] = false;
        $notificationType[3] = false;
        $notificationType[4] = false;
        $notificationType[5] = true;
        $notificationType[6] = false;
        $notificationType[7] = false;

        $trackingThresholdValue = array();

        $trackingThresholdValue[0] = array(
            "thresholdValue" => $productPrice,
            "domain" =>  1,
            "csvType" => 1,
            "isDrop" => true
        );
        $trackingThresholdValue[1] = array(
            "thresholdValue" => $productPrice,
            "domain" =>  1,
            "csvType" => 1,
            "isDrop" => false
        );

        $trackingNotifyIf = array();
        $trackingNotifyIf[0] = array(
            "domain" => 1,
            "csvType" => 1,
            "notifyIfType" => 0,
        );
        $trackingNotifyIf[1] = array(
            "domain" => 1,
            "csvType" => 1,
            "notifyIfType" => 1,
        );

        $trackData = array(
            "asin" => $productASIN,
            "ttl" => 0,
            "expireNotify" => true,
            "desiredPricesInMainCurrency" => true,
            "mainDomainId" => 1,
            "updateInterval" => 1,
            "thresholdValues" => $trackingThresholdValue,
            "notifyIf" => $trackingNotifyIf,
            'notificationType' => $notificationType,
            "individualNotificationInterval" => -1
        );

//        return new JsonResponse($trackData);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://api.keepa.com/tracking?key=".Configuration::keepaAccessToken."&type=add",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($trackData),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 3926067a-03ee-f119-ae37-d7b674ce0507"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return new JsonResponse(json_decode($response));
        }

        return new JsonResponse("{}");
    }
}