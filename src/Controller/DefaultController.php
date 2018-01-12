<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/api/getToken", methods={"POST"})
     */
    public function getTokenAction()
    {
        // The security layer will intercept this request
        return new Response('', 401);
    }
}