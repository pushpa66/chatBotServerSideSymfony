<?php
/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 3/9/2018
 * Time: 1:25 AM
 */

namespace AppBundle\Controller;

use AppBundle\Structs\FbBot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MessageController extends Controller
{
    /**
     * @Route("/api/message", name="message")
     */
    public function indexAction(Request $request)
    {
        $bot = new FbBot();
        $recipient = "1699750453417285";
        $message = "Hello..";
        $bot->sendMessage($recipient, $message);
        return new Response('');
    }
}