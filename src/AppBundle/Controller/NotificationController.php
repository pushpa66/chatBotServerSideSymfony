<?php
/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 3/9/2018
 * Time: 2:45 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Notification;
use AppBundle\Repository\UserProductRepository;
use AppBundle\Structs\Configuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\UserProduct;
use Doctrine\ORM\EntityManagerInterface;

class NotificationController extends Controller
{
    /**
     * @Route("/api/checkNotifications", name="checkNotifications")
     */

    public function checkNotifications(){
        $result = $this->getNotificationsFromKeepa();

        if($result!= null) {
            $arraySize = sizeof($result);

            $userIDs = array();

            for ($i = 0; $i < $arraySize; $i++) {
                $productASIN = $result[$i]['asin'];
                $title = $result[$i]['title'];
                $image = $result[$i]['image'];
                $price = $result[$i]['price'];
                $notifyType = $result[$i]['trackingNotificationCause'];
                $listName = $result[$i]['trackingListName'];


                // create an entity manager
                $entityManager = $this->getDoctrine()->getManager();
                $availableNotification = $this->getDoctrine()
                    ->getRepository(Notification::class)
                    ->findoneBy(
                        array('userID' => $listName,'productASIN' => $productASIN)
                    );
                if(!in_array($listName, $userIDs)){
                    array_push($userIDs, $listName);
                }

                if(!$availableNotification){
                    $notification = new Notification();
                    $notification->setUserID($listName);
                    $notification->setProductASIN($productASIN);
                    $notification->setTitle($title);
                    $notification->setImage($image);
                    $notification->setPrice($price);
                    $notification->setNotifyType($notifyType);
                    $entityManager->persist($notification);
                } else {
                    $availableNotification->setUserID($listName);
                    $availableNotification->setProductASIN($productASIN);
                    $availableNotification->setTitle($title);
                    $availableNotification->setImage($image);
                    $availableNotification->setPrice($price);
                    $availableNotification->setNotifyType($notifyType);
                }

                $entityManager->flush();
            }


            for ($i = 0; $i < sizeof($userIDs); $i++){

                $botID = Configuration::botID;
                $userID = $userIDs[$i];
                $token = Configuration::token;
                $blockID = Configuration::blockID;
                $this->sendingBlock($botID, $userID, $token, $blockID);
            }
        }

        $response = array('status' => 'Ok');
        return new JsonResponse($response);
    }

    public function getNotificationsFromKeepa(){

        $value = 0;
        if (Configuration::testNotifications){
            $value = 1;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://api.keepa.com/tracking?key=".Configuration::keepaAccessToken."&type=notification&revise=$value",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 0c5532f8-4e33-b576-4eec-e1121ec5a62f"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $priceChangedASINs = array();

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $numberOfNotifications = sizeof($response['notifications']);

            if($numberOfNotifications != 0){

                for($i = 0; $i < $numberOfNotifications; $i++){
                    $priceTemp = 0;
                    for ($k = 0; $k < sizeof($response['notifications'][$i]['currentPrices']); $k++){
                        $priceTemp = $response['notifications'][$i]['currentPrices'][$k];
                        if ($priceTemp != -1){
                            break;
                        }
                    }

                    if ($priceTemp == -1) {
                        $price = 'not-given';
                    } else {
                        $price = floatval($priceTemp) / 100;
                    }

                    $priceChangedASINs[$i] = array(
                        'asin' => $response['notifications'][$i]['asin'],
                        'title' => $response['notifications'][$i]['title'],
                        'image' => $response['notifications'][$i]['image'],
                        'price' => $price,
                        'trackingNotificationCause' => $response['notifications'][$i]['trackingNotificationCause'],
                        'trackingListName' => $response['notifications'][$i]['trackingListName']
                    );

                }
            }
        }
        return $priceChangedASINs;
    }

    public function setTrackNotificationCause($number){
//        0 - EXPIRED:
//        1 - DESIRED_PRICE:
//        2 - PRICE_CHANGE:
//        3 - PRICE_CHANGE_AFTER_DESIRED_PRICE:
//        4 - OUT_STOCK:
//        5 - IN_STOCK:
//        6 - DESIRED_PRICE_AGAIN:
        $out0 = "Tracking expired";
        $out1 = "Desired price/value was met the first time";
        $out2 = "Price/Value changed";
        $out3 = "Price/value changed after desired price/value was already met once and the tracking was rearmed but did not pass the desired threshold since.";
        $out4 = "Product is now out of stock";
        $out5 = "Product is now back in stock";
        $out6 = "Desired price/value was met again after the value was out of the threshold and the tracking was rearmed";

        switch ($number) {
            case '0':
                return $out0;
            case '1':
                return $out1;
            case '2':
                return $out2;
            case '3':
                return $out3;
            case '4':
                return $out4;
            case '5':
                return $out5;
            case '6':
                return $out6;
            default:
                return "Code is invalid!";
        }
    }

    public function sendingBlock($botID, $userID, $token, $blockID){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://api.chatfuel.com/bots/$botID/users/$userID/send?chatfuel_token=$token&chatfuel_block_id=$blockID",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 36196e19-5e17-cd1e-72b3-402c70f019d1"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
    }

    /**
     * @Route("/api/sendNotifications", name="sendNotifications")
     */
    public function sendNotifications(Request $request){
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');


        $notifications = $this->getDoctrine()
            ->getRepository(Notification::class)
            ->findBy(
                array('userID' => $userID)
            );

        $jsonList = array();
        $jsonList['messages'] = array();
        $jsonList['messages'][0] = array("text" => "Hi $userFirstName, You have notifications!");
        $notificationCount = sizeof($notifications);


        $entityManager = $this->getDoctrine()->getManager();


        for ($index = 0; $index < $notificationCount; $index++) {

            $userID = $notifications[$index]->getUserID();
            $productASIN = $notifications[$index]->getProductASIN();
            $productTitle = $notifications[$index]->getTitle();
            $productImage = $notifications[$index]->getImage();
            $productPrice = $notifications[$index]->getPrice();
            $notificationMessage = $this->setTrackNotificationCause($notifications[$index] -> getNotifyType());

            $url = "https://www.amazon.com/dp/$productASIN";

            $jsonList['messages'][2 * $index + 1] = array("text" => $notificationMessage);
            $jsonList['messages'][2 * $index + 2]['attachment'] = array("type" => "template");
            $jsonList['messages'][2 * $index + 2]['attachment']['payload'] = array("template_type" => "generic", 'elements' => array());
            $jsonList['messages'][2 * $index + 2]['attachment']['payload']['elements'][0] = array('title' => '' . $productTitle, 'image_url' => "https://images-na.ssl-images-amazon.com/images/I/$productImage", 'subtitle' => '$ ' . $productPrice, 'buttons' => array());
            $jsonList['messages'][2 * $index + 2]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'web_url', 'url' => $url, 'title' => 'View');
            $jsonList['messages'][2 * $index + 2]['attachment']['payload']['elements'][0]['buttons'][1] = array('type' => 'json_plugin_url', 'url' => Configuration::removeTrackedProductApiUrl.$productASIN.'&id='.$userID, 'title' => 'Remove');
            $jsonList['messages'][2 * $index + 2]['attachment']['payload']['elements'][0]['buttons'][2] = array('type' => 'json_plugin_url', 'url' => Configuration::trackProductApiUrl.$productASIN.'&id='.$userID.'&userFirstName='.$userFirstName.'&price='.$productPrice, 'title' => 'Track Again');


        }

        for ($index = 0; $index < $notificationCount; $index++) {
            $entityManager->remove($notifications[$index]);
        }

        $entityManager->flush();

        return new JsonResponse($jsonList);
    }
}