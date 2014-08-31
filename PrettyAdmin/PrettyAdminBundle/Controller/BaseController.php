<?php

namespace PrettyAdmin\PrettyAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseController extends Controller
{
    protected $container;
    private $request;
    protected $em;
    public $connection;
    public $entityName;
    public $bundle;
    public $namespace;
    public $entityMetadata;
    public $prettyAdminParams;
    public $repository;
    public $requestEntity;
    public $entityTableName;
    public $fields;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->request = $container->get('request');
        $this->em = $container->get('doctrine')->getManager();
        $this->connection = $container->get('database_connection');
        $this->prettyAdminParams = $container->getParameter('pretty_admin');
        $this->initPrettyAdminParams();
    }

    private function initPrettyAdminParams()
    {
        if($this->request->get('entity', null) == null) {
            return;
        }

        $entityName = ucfirst(substr($this->request->get('entity'), 0, strlen($this->request->get('entity')) - 1));
        if(in_array($entityName, $this->prettyAdminParams['entities']['list'])) {
            $this->entityName = $entityName;
            $this->bundle = $this->prettyAdminParams['entities']['bundle'];
            $this->namespace = $this->prettyAdminParams['entities']['namespace'];
            $this->repository = sprintf("%s:%s", $this->bundle, $this->entityName);
            $this->requestEntity = $this->request->get('entity');
            $this->entityMetadata = $this->em->getClassMetadata($this->repository);
            $this->entityTableName = $this->entityMetadata->getTableName();
            $this->fields = $this->entityMetadata->fieldMappings;
        }
        else {
            throw new \Exception(sprintf("Entity %s is not registered. Check it out in your config file", $entityName));
        }
    }
}