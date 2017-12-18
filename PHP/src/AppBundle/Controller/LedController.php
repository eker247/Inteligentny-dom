<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utils\LedDriver;
use Symfony\Component\Config\Definition\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class LedController extends Controller
{
    private $driver;
    public function __construct()
    {
        $this->driver = new LedDriver();
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $color = $this->driver->readColor();
        return $this->render('led/index.html.twig', ['color' => $color]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function setcolorAction(Request $request, $color)
    {
        var_dump($color);
        $this->driver->setColor($color);
        // return new Response("");
        return $this->redirectToRoute('led_index');
    }
}
