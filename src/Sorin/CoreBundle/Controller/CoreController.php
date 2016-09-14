<?php

namespace Sorin\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('SorinCoreBundle:Core:layout.html.twig');
    }
}
