<?php
/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 3/10/2018
 * Time: 9:22 PM
 */

namespace AppBundle\Structs;


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
    const botID = "5a968c95e4b05207f7628608";
    const token = "vnbqX6cpvXUXFcOKr5RHJ7psSpHDRzO1hXBY8dkvn50ZkZyWML3YdtoCnKH7FSjC";
    const blockID = "5aa3ad07e4b094306df10a53";
    const keepaAccessToken = "bmccnl2m5292v3soegcl3abtfe8cd8dbbpg1r7oddnuirodk9h2imk8djkbht4lk";
    const fbAccessToken = "EAAEZChN9WqTYBALwFF6VLYSoqbYB45TzVjMm4TNk8ArI9sgdeqlrckWKTZBtdRipxZCy0gLTiGZCo1mowZCDehmD3rRBbcwSivHJvvxEzfspRVnXQFccpnqLevUbjdOMBYPlZCI44ZCXNLh6ukTJ5YuVz5TfDxmi5PS9sosCGumTZA6lIoBTEjq0";



    //get all tracked asin list
    //https://api.keepa.com/tracking?key=bmccnl2m5292v3soegcl3abtfe8cd8dbbpg1r7oddnuirodk9h2imk8djkbht4lk&type=list&asins-only=1
}