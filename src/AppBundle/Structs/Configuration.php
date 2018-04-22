<?php
/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 3/10/2018
 * Time: 9:22 PM
 */

namespace AppBundle\Structs;


use Doctrine\ORM\Query\AST\Functions\ConcatFunction;

class Configuration
{
    const showItemCount = 10;
    const published = true;
    const testNotifications = false;
//    const testNotifications = true;


//    const serverUrl = "https://68ab7aa5.ngrok.io";
//    const projectFolder = "chatbot-master";
//
    const serverUrl = "http://167.99.58.137";
    const projectFolder = "chatBotServerSideSymfony";

    const findSearchApiUrl = Configuration::serverUrl."/".Configuration::projectFolder."/web/app_dev.php/api?asin=";
    const trackApiUrl = Configuration::serverUrl."/".Configuration::projectFolder."/web/app_dev.php/api/track?asin=";
    const trackProductApiUrl = Configuration::serverUrl."/".Configuration::projectFolder."/web/app_dev.php/api/trackProduct?asin=";
    const removeTrackedProductApiUrl = Configuration::serverUrl."/".Configuration::projectFolder."/web/app_dev.php/api/removeTrackedProduct?asin=";

    const setDomainApiUrl = Configuration::serverUrl."/".Configuration::projectFolder."/web/app_dev.php/api/setDomain?";
    const showDomainsApiUrl = Configuration::serverUrl."/".Configuration::projectFolder."/web/app_dev.php/api/showDomains?";

    /**
    const botID = "5a968c95e4b05207f7628608";
    const token = "vnbqX6cpvXUXFcOKr5RHJ7psSpHDRzO1hXBY8dkvn50ZkZyWML3YdtoCnKH7FSjC";
    const blockID = "5aca172de4b0336c5476ecbb";
     */

    const botID = "5a7f9efbe4b01cc9f958c300";
    const token = "vnbqX6cpvXUXFcOKr5RHJ7psSpHDRzO1hXBY8dkvn50ZkZyWML3YdtoCnKH7FSjC";
    const blockID = "5acfa6cce4b075d7d7c3ffa1";

    //https://dashboard.chatfuel.com/#/bot/5a7f9efbe4b01cc9f958c300/structure/5acfa6cce4b075d7d7c3ffa1

    const keepaAccessToken = "bmccnl2m5292v3soegcl3abtfe8cd8dbbpg1r7oddnuirodk9h2imk8djkbht4lk";
    const fbAccessToken = "EAAEZChN9WqTYBALwFF6VLYSoqbYB45TzVjMm4TNk8ArI9sgdeqlrckWKTZBtdRipxZCy0gLTiGZCo1mowZCDehmD3rRBbcwSivHJvvxEzfspRVnXQFccpnqLevUbjdOMBYPlZCI44ZCXNLh6ukTJ5YuVz5TfDxmi5PS9sosCGumTZA6lIoBTEjq0";

    const Domain = ['com', 'co.uk', 'de', 'fr', 'co.jp', 'ca', 'cn', 'it', 'es', 'in', 'com.mx', 'com.br'];
    const Country = ['United States', 'United Kingdom', 'Germany', 'France', 'Japan', 'Canada', 'China', 'Italy', 'Spain', 'India', 'Mexico', 'Brazil'];
    const Currency = ['$', '£', 'EUR', 'EUR', '¥', 'CDN$', '¥', '‎EUR', 'EUR', 'INR', '$', 'R$'];


    //get all tracked asin list
    //https://api.keepa.com/tracking?key=bmccnl2m5292v3soegcl3abtfe8cd8dbbpg1r7oddnuirodk9h2imk8djkbht4lk&type=list&asins-only=1
}