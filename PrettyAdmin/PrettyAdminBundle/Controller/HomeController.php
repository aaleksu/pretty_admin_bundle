<?php

namespace PrettyAdmin\PrettyAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
    public function indexAction(Request $request)
    {
        return $this->render('PrettyAdminBundle:Home:index.html.twig');
    }
}
