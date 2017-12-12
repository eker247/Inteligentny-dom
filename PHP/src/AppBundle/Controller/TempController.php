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
    public function tempSetterAction($tid = 0, $actual = 0, $required = 0, $tolerance = 0)
    {
        $this->driver->setTemps($_POST);
        // return new Response("<br />Wygenerował");
        return $this->redirectToRoute('temp_index');
        // try {
        //     $this->driver->SwitchLight($tid);
        // }
        // catch (Exception $ex) {
        //     return new Response($ex->getMessage());
        // }
        // return $this->redirectToRoute('temp_index');
    }
}
