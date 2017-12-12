<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\LightDriver;
use Symfony\Component\Config\Definition\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class LedController extends Controller
{
    private $driver;
    public function __construct()
    {
        $this->driver = new LightDriver();
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request, $color = "black")
    {
        // var_dump($color);
        $rooms = $this->driver->LampStatuses();
        return $this->render('led/index.html.twig', ['rooms' => $rooms, 'color' => $color]);
    }

    // /**
    //  * @Security("has_role('ROLE_ADMIN')")
    //  */
    // public function transmitterAction($tid = 0)
    // {
    //     try {
    //         $this->driver->SwitchLight($tid);
    //     }
    //     catch (Exception $ex) {
    //         return new Response($ex->getMessage());
    //     }
    //     return $this->redirectToRoute('light_index');
    // }
}
