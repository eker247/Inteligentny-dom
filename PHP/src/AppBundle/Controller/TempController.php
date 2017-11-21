<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\TempDriver;
use Symfony\Component\Config\Definition\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class TempController extends Controller
{
    private $driver;
    public function __construct()
    {
        $this->driver = new TempDriver();
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        return $this->render('temp/index.html.twig', [
            'rooms' => $this->driver->TempStatuses()
        ]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function tempSetterAction($tid = 0, $actual, $required, $tolerance)
    {

        return new Response("tutaj");
        // try {
        //     $this->driver->SwitchLight($tid);
        // }
        // catch (Exception $ex) {
        //     return new Response($ex->getMessage());
        // }
        // return $this->redirectToRoute('temp_index');
    }
}
