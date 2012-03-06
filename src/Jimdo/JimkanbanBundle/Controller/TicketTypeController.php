<?php

namespace Jimdo\JimkanbanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jimdo\JimkanbanBundle\Entity\TicketType;
use Jimdo\JimkanbanBundle\Form\TicketTypeType;

/**
 * TicketType controller.
 *
 */
class TicketTypeController extends Controller
{
    /**
     * Lists all TicketType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JimdoJimkanbanBundle:TicketType')->findAll();

        return $this->render('JimdoJimkanbanBundle:TicketType:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Displays a form to create a new TicketType entity.
     *
     */
    public function newAction()
    {
        $entity = new TicketType();
        $form   = $this->createForm(new TicketTypeType(), $entity);

        return $this->render('JimdoJimkanbanBundle:TicketType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new TicketType entity.
     *
     */
    public function createAction()
    {
        $entity  = new TicketType();
        $request = $this->getRequest();
        $form    = $this->createForm(new TicketTypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tickettype_edit', array('id' => $entity->getId())));
            
        }

        return $this->render('JimdoJimkanbanBundle:TicketType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing TicketType entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JimdoJimkanbanBundle:TicketType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TicketType entity.');
        }

        $editForm = $this->createForm(new TicketTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JimdoJimkanbanBundle:TicketType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing TicketType entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JimdoJimkanbanBundle:TicketType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TicketType entity.');
        }

        $editForm   = $this->createForm(new TicketTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tickettype_edit', array('id' => $id)));
        }

        return $this->render('JimdoJimkanbanBundle:TicketType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TicketType entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JimdoJimkanbanBundle:TicketType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TicketType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tickettype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
