<?php

namespace Jimdo\JimkanbanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jimdo\JimkanbanBundle\Entity\TicketType;
use Jimdo\JimkanbanBundle\Form\TicketType as TicketTypeForm;

/**
 * TicketType controller.
 *
 */
class TicketTypeController extends Controller
{
    /**
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function indexAction()
    {
        $entities = $this->repository()->findAll();

        return $this->render('JimdoJimkanbanBundle:TicketType:index.html.twig', array(
            'entities' => $entities
        ));
    }


    /**
    * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
    */
    public function newAction()
    {
        $ticketType = new TicketType();
        $form   = $this->createTicketTypeForm($ticketType);

        return $this->render('JimdoJimkanbanBundle:TicketType:new.html.twig', array(
                                                                                   'entity' => $ticketType,
                                                                                   'form'   => $form->createView()
        ));
    }

    /**
    * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse|\Symfony\Bundle\FrameworkBundle\Controller\Response
    */
    public function createAction()
    {
        $ticketType  = new TicketType();
        $request = $this->getRequest();
        $form    = $this->createTicketTypeForm($ticketType);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->entityManager();
            $em->persist($ticketType);
            $em->flush();

            return $this->redirect($this->generateUrl('tickettype_edit', array('id' => $ticketType->getId())));

        }

        return $this->render('JimdoJimkanbanBundle:TicketType:new.html.twig', array(
                                                                                   'entity' => $ticketType,
                                                                                   'form'   => $form->createView()
        ));
    }


    /**
    * @throws \Symfony\Bundle\FrameworkBundle\Controller\NotFoundHttpException
    * @param $id
    * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
    */
    public function editAction($id)
    {
        $em = $this->entityManager();

        $entity = $this->replace()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TicketType entity.');
        }

        $editForm = $this->createTicketTypeForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JimdoJimkanbanBundle:TicketType:edit.html.twig', array(
                                                                                    'entity'      => $entity,
                                                                                    'edit_form'   => $editForm->createView(),
                                                                                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * @throws \Symfony\Bundle\FrameworkBundle\Controller\NotFoundHttpException
    * @param $id
    * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse|\Symfony\Bundle\FrameworkBundle\Controller\Response
    */
    public function updateAction($id)
    {
        $em = $this->entityManager();

        $entity = $this->repository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TicketType entity.');
        }

        $editForm = $this->createTicketTypeForm($entity);
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
    * @throws \Symfony\Bundle\FrameworkBundle\Controller\NotFoundHttpException
    * @param $id
    * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
    */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity = $this->repository()->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TicketType entity.');
            }

            $em = $this->entityManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tickettype'));
    }

    /**
    * @param $id
    * @return Symfony\Component\Form\FormBuilder
    */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
                ;
    }

    /**
    * @param $entity
    * @return \Symfony\Bundle\FrameworkBundle\Controller\Form
    */
    private function createTicketTypeForm($entity)
    {
        return $this->createForm(new TicketTypeForm(), $entity);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function entityManager()
    {
        return $this->getDoctrine()->getEntityManager();

    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function repository()
    {
        $em = $this->entityManager();
        $repository = $em->getRepository('JimdoJimkanbanBundle:TicketType');
        return $repository;
    }
}
