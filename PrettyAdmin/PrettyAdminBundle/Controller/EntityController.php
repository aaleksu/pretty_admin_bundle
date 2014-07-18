<?php

namespace PrettyAdmin\PrettyAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EntityController extends BaseController
{
    public function indexAction(Request $request)
    {
        $entities = $this->em->getRepository(sprintf("%s:%s", $this->bundle, $this->entity))->findAll();
        $entityMetadata = $this->em->getClassMetadata(sprintf("%s:%s", $this->bundle, $this->entity));

        return $this->render('PrettyAdminBundle:Entity:index.html.twig', array(
            'entities' => $entities,
            'fields' => $entityMetadata->fieldNames
        ));
    }

    public function showAction(Request $request, $id)
    {
    }

    public function newAction(Request $request)
    {
        $entityClass = sprintf("\%s\%s\Entity\%s", $this->namespace, $this->bundle, $this->entity);
        $entity = new $entityClass;

        return $this->render('PrettyAdminBundle:Entity:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'create_route' => $this->generateUrl('pretty_admin_entity_create', array(
                'entity' => $request->get('entity')
            ))
        ));
    }

    public function createAction(Request $request)
    {
        try {
            $this->getFlashBag()->add('info', sprintf("%s has been successfully created", $this->entity));

            return $this->redirect();
        }
        catch(\Exception $e) {
            $this->getFlashBag()->add('error', $e->getMessage());
        }
    }

    public function editAction(Request $request, $id)
    {
        return $this->render('PrettyAdminBundle:Entity:edit.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'update_route' => $this->generateUrl('pretty_admin_entity_update', array(
                'entity' => $request->get('entity'),
                'id' => $id
            ))
        ));
    }

    public function updateAction(Request $request)
    {
        
    }
}
