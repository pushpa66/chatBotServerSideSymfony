<?php
/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 4/8/2018
 * Time: 1:17 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Structs\Configuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainController extends Controller
{
    /**
    * @Route("/api/setDomain", name="setDomain")
    */
    public function setDomain(Request $request){
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');
        $domain = $request->get('domain');

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findoneBy(
                array('userID' => $userID)
            );

        $entityManager = $this->getDoctrine()->getManager();

        if(!$user){
            $newUser = new User();
            $newUser->setUserID($userID);
            $newUser->setUserFirstName($userFirstName);
            $newUser->setDomainID($domain);
            $entityManager->persist($newUser);
        } else {
            $user->setDomainID($domain);
        }

        $entityManager->flush();

        $message = array();
        $message['messages'] = array();
        $message['messages'][] = array('text' => "Now you find product on www.amazon.".Configuration::Domain[$domain - 1].". Try with key word or product asin.");
        return new JsonResponse($message);

    }

    /**
     * @Route("/api/showDomains", name="showDomains")
     */
    public function showDomains(Request $request){
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');

        //=============================================
        $jsonList['messages'][0] = array('text' => "Set your domain");
        //=============================================

        for ($i = 0; $i < 3 ; $i++){
            $jsonList['messages'][$i + 1]['attachment'] = array("type" => "template");
            $jsonList['messages'][$i + 1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());

            for ($j = 0; $j < 4; $j++){
                $jsonList['messages'][$i + 1]['attachment']['payload']['elements'][$j] = array('title' => Configuration::Country[$i * 4 + $j], 'subtitle' => "www.amazon.".Configuration::Domain[$i * 4 + $j], 'buttons' => array());
                $domain = $i * 4 + $j + 1;
                $jsonList['messages'][$i + 1]['attachment']['payload']['elements'][$j]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::setDomainApiUrl."id=$userID&userFirstName=$userFirstName&domain=$domain", 'title' => 'Set');
            }
        }

         return new JsonResponse($jsonList);
    }

    /**
     * @Route("/api/searchAndSettings", name="searchAndSettings")
     */
    public function searchAndSettings(Request $request){
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findoneBy(
                array('userID' => $userID)
            );

        $entityManager = $this->getDoctrine()->getManager();
        $domain = "1";
        if(!$user){
            $newUser = new User();
            $newUser->setUserID($userID);
            $newUser->setUserFirstName($userFirstName);
            $newUser->setDomainID($domain);
            $entityManager->persist($newUser);
        } else {
            $domain = $user->getDomain();
        }

        $entityManager->flush();

        $jsonList['messages'][0] = array('text' => "What can I do for you today, $userFirstName!");
        $jsonList['messages'][1]['attachment'] = array("type" => "template");
        $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][0] = array('title' => "Search", 'subtitle' => "Find product from amazon.".Configuration::Domain[$domain - 1], 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'web_url', 'url' => 'https://www.amazon.com', 'title' => 'Search');
        $jsonList['messages'][1]['attachment']['payload']['elements'][1] = array('title' => "Settings", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][1]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        return new JsonResponse($jsonList);
    }
}