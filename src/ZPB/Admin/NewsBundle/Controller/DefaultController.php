<?php

namespace ZPB\Admin\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZPBAdminNewsBundle:Default:index.html.twig');
    }
}
