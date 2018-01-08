<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\WaterValveDriver;
use Symfony\Component\Config\Definition\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class WaterValveController extends Controller
{
    private $driver;
    public function __construct()
    {
        $this->driver = new WaterValveDriver();
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $status = 'NIEZNANY';
        try {
            $status = $this->driver->status();
        }
        catch (Exception $ex){
            var_dump($ex->getMessage());
        }
        // status is 'ZAMKNIĘTY' or 'OTWARTY'
        return $this->render('watervalve/index.html.twig', ['status' => $status]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function changeAction(Request $request)
    {
        $this->driver->change();
        return $this->redirectToRoute('watervalve_index');
    }
}
