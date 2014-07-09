<?php

namespace PrettyAdmin\PrettyAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
    public function indexAction(Request $request)
    {
        return new Response(__FILE__);
    }
}
