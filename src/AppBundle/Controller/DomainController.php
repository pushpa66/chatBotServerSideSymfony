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

        $jsonList['messages'][0] = array('text' => "Set one of the following domains");
        $jsonList['messages'][1]['attachment'] = array("type" => "template");
        $jsonList['messages'][1]['attachment']['payload'] = array("template_type" => "list", "top_element_style" => "compact", 'elements' => array());
        //United States
        $jsonList['messages'][1]['attachment']['payload']['elements'][0] = array('title' => "United States", 'subtitle' => ".com", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][0]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        //United Kingdom
        $jsonList['messages'][1]['attachment']['payload']['elements'][1] = array('title' => "United Kingdom", 'subtitle' => ".co.uk", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][1]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][2] = array('title' => "United States", 'subtitle' => "fd", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][2]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][3] = array('title' => "sdds", 'subtitle' => "dddd", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][3]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][4] = array('title' => "Ussd", 'subtitle' => "Ydsd", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][4]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
        /**
        $jsonList['messages'][1]['attachment']['payload']['elements'][5] = array('title' => "xxasc", 'subtitle' => "dsd", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][5]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][6] = array('title' => "United States", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][6]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][7] = array('title' => "United States", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][7]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][8] = array('title' => "United States", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][8]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][9] = array('title' => "United States", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][9]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][10] = array('title' => "United States", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][10]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');

        $jsonList['messages'][1]['attachment']['payload']['elements'][11] = array('title' => "United States", 'subtitle' => "You can setup your domain", 'buttons' => array());
        $jsonList['messages'][1]['attachment']['payload']['elements'][11]['buttons'][0] = array('type' => 'json_plugin_url', 'url' => Configuration::showDomainsApiUrl."id=$userID&userFirstName=$userFirstName", 'title' => 'Settings');
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