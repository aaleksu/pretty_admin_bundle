<?php

namespace PrettyAdmin\PrettyAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use PrettyAdmin\PrettyAdminBundle\Form\EntityType;

class EntityController extends BaseController
{
    public function indexAction(Request $request)
    {
        $entities = $this->connection->fetchAll(sprintf("select * from %s", $this->entityTableName));

        array_walk($entities, function(&$entity, $key){
            $entity['show_route'] = $this->generateUrl('pretty_admin_entity_show', array('entity' => $this->requestEntity, 'id' => $entity['id']));
            $entity['edit_route'] = $this->generateUrl('pretty_admin_entity_edit', array('entity' => $this->requestEntity, 'id' => $entity['id']));
            $entity['delete_route'] = $this->generateUrl('pretty_admin_entity_delete', array('entity' => $this->requestEntity, 'id' => $entity['id']));
        });

        $viewVars = array(
            'entityName' => $this->entityName,
            'requestEntity' => $this->requestEntity,
            'entities' => $entities,
            'fields' => $this->entityMetadata->fieldNames
        );

        if($request->get('_format') == 'json') {
            return new JsonResponse($viewVars);
        }

        return $this->render('PrettyAdminBundle:Entity:index.html.twig', $viewVars);
    }

    public function showAction(Request $request, $id)
    {
        $entity = $this->connection->fetchAssoc(sprintf("select * from %s where id = %d", $this->entityTableName, $id));

        if($request->get('_format') == 'json') {
            return new JsonResponse($entity);
        }

        return $this->render('PrettyAdminBundle:Entity:show.html.twig', array(
            'entityName' => $this->entityName,
            'entity' => $entity,
        ));
    }

    public function newAction(Request $request)
    {
        return $this->render('PrettyAdminBundle:Entity:new.html.twig', array(
            'requestEntity' => $this->requestEntity,
            'entityName' => $this->entityName,
            'fields' => $this->fields,
            'form_action' => $this->generateUrl('pretty_admin_entity_create', array(
                'entity' => $this->requestEntity,
            ))
        ));
    }

    public function createAction(Request $request)
    {
        try {
            $fieldValues = array();
            $values = array_map(function($field) use ($request, &$fieldValues){
                $fieldValue = $field == 'id' ? 'null' : sprintf("'%s'", $request->get($field));
                return $fieldValue;
            }, $this->entityMetadata->getColumnNames());
            $insertQuery = sprintf("insert into %s (%s) values (%s)", $this->entityTableName, join(',', $this->entityMetadata->getColumnNames()), join(',', $values));
            $this->connection->exec($insertQuery);
            $this->get('session')->getFlashBag()->add('info', sprintf("%s has been successfully created", $this->entityName));

            return $this->redirect($this->generateUrl('pretty_admin_entity_index', array(
                'entity' => $this->requestEntity
            )));
        }
        catch(\Exception $e) {
            _dbg($e->getMessage());
            $this->get('session')->getFlashBag()->add('error', $e->getMessage());

            return $this->redirect($this->generateUrl('pretty_admin_entity_new', array(
                'entity' => $this->requestEntity,
            )));
        }
    }

    public function editAction(Request $request, $id)
    {
        //$entity = $this->
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

    public function deleteAction(Request $request, $id)
    {
        try {
            $this->connection->exec(sprintf("delete from %s where id = %d", $this->entityTableName, $id));

            return new JsonResponse(array('status' => 'ok'));
        }
        catch(\Exception $e) {
            return new JsonResponse(array('status' => 'fail'));
        }
    }
}
