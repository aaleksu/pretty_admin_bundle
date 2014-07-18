<?php

namespace PrettyAdmin\PrettyAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseController extends Controller
{
    protected $container;
    protected $em;
    protected $entity;
    protected $bundle;
    protected $namespace;
    protected $prettyAdminParams;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine')->getManager();
        $this->prettyAdminParams = $container->getParameter('pretty_admin');
        $this->initPrettyAdminParams();
    }

    private function initPrettyAdminParams()
    {
        $request = $this->container->get('request');
        $entityName = ucfirst(substr($request->get('entity'), 0, strlen($request->get('entity')) - 1));
        if(in_array($entityName, $this->prettyAdminParams['entities']['list'])) {
            $this->entity = $entityName;
            $this->bundle = $this->prettyAdminParams['entities']['bundle'];
            $this->namespace = $this->prettyAdminParams['entities']['namespace'];
        }
        else {
            throw new \Exception(sprintf("Entity %s is not registered. Check it out in your config file", $entityName));
        }
    }
}
