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
    const ngrokUrl = "https://e58188dc.ngrok.io";
    const trackProductApiUrl = Configuration::ngrokUrl."/chatbot-master/web/app_dev.php/api/track?asin=";
    const removeTrackedProductApiUrl = Configuration::ngrokUrl."/chatbot-master/web/app_dev.php/api/removeTrackedProduct?asin=";
    const botID = "5a968c95e4b05207f7628608";
    const token = "vnbqX6cpvXUXFcOKr5RHJ7psSpHDRzO1hXBY8dkvn50ZkZyWML3YdtoCnKH7FSjC";
    const blockID = "5aa3ad07e4b094306df10a53";
    const keepaAccessToken = "bmccnl2m5292v3soegcl3abtfe8cd8dbbpg1r7oddnuirodk9h2imk8djkbht4lk";
    const fbAccessToken = "EAAEZChN9WqTYBALwFF6VLYSoqbYB45TzVjMm4TNk8ArI9sgdeqlrckWKTZBtdRipxZCy0gLTiGZCo1mowZCDehmD3rRBbcwSivHJvvxEzfspRVnXQFccpnqLevUbjdOMBYPlZCI44ZCXNLh6ukTJ5YuVz5TfDxmi5PS9sosCGumTZA6lIoBTEjq0";

    const published = false;

    const asin ="B0719925K5";
    const title = "GearWrench 82108 7 Piece Standard Pliers Master set";
    const image = "51JztTAjkTL.jpg";
    const price = "5.75";
    const trackingNotificationCause = '4';

}