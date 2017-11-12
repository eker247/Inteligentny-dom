<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\LightDriver;
use Symfony\Component\Config\Definition\Exception\Exception;

class LightController extends Controller
{
    private $driver;
    public function __construct()
    {
        $this->driver = new LightDriver();
    }

    public function indexAction(Request $request)
    {
        $rooms = $this->driver->LampStatuses();
        return $this->render('light/index.html.twig', ['rooms' => $rooms]);
    }

    public function transmitterAction($tid = 0)
    {
        try {
            $this->driver->SwitchLight($tid);
        }
        catch (Exception $ex) {
            return new Response($ex->getMessage());
        }
        return $this->redirectToRoute('light_index');
    }
}
