<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DriverController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('driver/index.html.twig');
    }

    public function transmitterAction($tnr = 0)
    {
        $text = ($tnr != 0) ?
            "To wywoła funkcję zapalającą światło " . $tnr :
            "Nie wybrano nr światła";
        return new Response($text);
    }
}
