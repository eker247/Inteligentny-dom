<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\BlindDriver;
use Symfony\Component\Config\Definition\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class BlindController extends Controller
{
    private $driver;
    public function __construct()
    {
        $this->driver = new BlindDriver();
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $rooms = $this->driver->BlindStatuses();
        return $this->render('blind/index.html.twig', ['rooms' => $rooms]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function switchBlindAction($tid = 0)
    {
        try {
            $this->driver->SwitchBlind($tid);
        }
        catch (Exception $ex) {
            return new Response($ex->getMessage());
        }
        return $this->redirectToRoute('blind_index');
    }
}
