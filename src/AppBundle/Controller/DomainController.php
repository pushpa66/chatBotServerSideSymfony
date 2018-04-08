<?php
/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 4/8/2018
 * Time: 1:17 AM
 */

namespace AppBundle\Controller;

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
    }

    /**
     * @Route("/api/showDomains", name="showDomains")
     */
    public function showDomains(Request $request){
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');

        //=============================================
        $jsonList['messages'][0] = array('text' => "Set one of the following domains");
        //=============================================

        for ($i = 0; $i < 3 ; $i++){
            $jsonList['messages'][$i + 1]['attachment'] = array("type" => "template");
            $jsonList['messages'][$i + 1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());

            for ($j = 0; $j < 4; $j++){
                $jsonList['messages'][$i + 1]['attachment']['payload']['elements'][$j] = array('title' => Configuration::Country[$i * 4 + $j], 'subtitle' => "www.amazon.".Configuration::Domain[$i * 4 + $j], 'buttons' => array());
                $jsonList['messages'][$i + 1]['attachment']['payload']['elements'][$j]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Set');
            }
        }
        /**
        $jsonList['messages'][1]['attachment'] = array("type" => "template");
        $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());
        //United States
        $jsonList['messages'][1]['attachment']['payload']['elements'][0] = array('title' => "United States", 'subtitle' => ".com", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //United Kingdom
        $jsonList['messages'][1]['attachment']['payload']['elements'][1] = array('title' => "United Kingdom", 'subtitle' => ".co.uk", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][1]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //Germany
        $jsonList['messages'][1]['attachment']['payload']['elements'][2] = array('title' => "Germany", 'subtitle' => "fd", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][2]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //France
        $jsonList['messages'][1]['attachment']['payload']['elements'][3] = array('title' => "France", 'subtitle' => "dddd", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][3]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        //==================================================
        $jsonList['messages'][2]['attachment'] = array("type" => "template");
        $jsonList['messages'][2]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());
        //Japan
        $jsonList['messages'][2]['attachment']['payload']['elements'][0] = array('title' => "Japan", 'subtitle' => "Ydsd", 'buttons' => array());
        $jsonList['messages'][2]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //Canada
        $jsonList['messages'][2]['attachment']['payload']['elements'][1] = array('title' => "Canada", 'subtitle' => "dsd", 'buttons' => array());
        $jsonList['messages'][2]['attachment']['payload']['elements'][1]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //China
        $jsonList['messages'][2]['attachment']['payload']['elements'][2] = array('title' => "China", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][2]['attachment']['payload']['elements'][2]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //Italy
        $jsonList['messages'][2]['attachment']['payload']['elements'][3] = array('title' => "Italy", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][2]['attachment']['payload']['elements'][3]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        //==================================================
        $jsonList['messages'][3]['attachment'] = array("type" => "template");
        $jsonList['messages'][3]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());
        //Spain
        $jsonList['messages'][3]['attachment']['payload']['elements'][0] = array('title' => "Spain", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][3]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //India
        $jsonList['messages'][3]['attachment']['payload']['elements'][1] = array('title' => "India", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][3]['attachment']['payload']['elements'][1]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //Mexico
        $jsonList['messages'][3]['attachment']['payload']['elements'][2] = array('title' => "Mexico", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][3]['attachment']['payload']['elements'][2]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //Brazil
        $jsonList['messages'][3]['attachment']['payload']['elements'][3] = array('title' => "Brazil", 'subtitle' => ".com.br", 'buttons' => array());
        $jsonList['messages'][3]['attachment']['payload']['elements'][3]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        */
         return new JsonResponse($jsonList);
    }

    /**
     * @Route("/api/searchAndSettings", name="searchAndSettings")
     */
    public function searchAndSettings(Request $request){
        $userID = $request->get('id');
        $userFirstName = $request->get('userFirstName');

        $jsonList['messages'][0] = array('text' => "What can I do for you today, $userFirstName!");
        $jsonList['messages'][1]['attachment'] = array("type" => "template");
        $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][0] = array('title' => "Search", 'subtitle' => "Find product from amazon.com", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'web_url', 'url' => 'https://www.amazon.com', 'title' => 'Search');
        $jsonList['messages'][1]['attachment']['payload']['elements'][1] = array('title' => "Settings", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][1]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        return new JsonResponse($jsonList);
    }



}