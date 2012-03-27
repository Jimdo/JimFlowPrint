<?php

namespace Jimdo\JimkanbanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jimdo\JimkanbanBundle\Entity\Printer;
use Jimdo\JimkanbanBundle\Form\PrinterType;

/**
 * Printer controller.
 *
 * @Route("/printer")
 */
class PrinterController extends Controller
{
    /**
     * Lists all Printer entities.
     *
     * @Route("/", name="printer")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JimdoJimkanbanBundle:Printer')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Printer entity.
     *
     * @Route("/{id}/show", name="printer_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JimdoJimkanbanBundle:Printer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Printer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Printer entity.
     *
     * @Route("/new", name="printer_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Printer();
        $form   = $this->createForm(new PrinterType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Printer entity.
     *
     * @Route("/create", name="printer_create")
     * @Method("post")
     * @Template("JimdoJimkanbanBundle:Printer:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Printer();
        $request = $this->getRequest();
        $form    = $this->createForm(new PrinterType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('printer_edit', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Printer entity.
     *
     * @Route("/{id}/edit", name="printer_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JimdoJimkanbanBundle:Printer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Printer entity.');
        }

        $editForm = $this->createForm(new PrinterType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Printer entity.
     *
     * @Route("/{id}/update", name="printer_update")
     * @Method("post")
     * @Template("JimdoJimkanbanBundle:Printer:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JimdoJimkanbanBundle:Printer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Printer entity.');
        }

        $editForm   = $this->createForm(new PrinterType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('printer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Printer entity.
     *
     * @Route("/{id}/delete", name="printer_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JimdoJimkanbanBundle:Printer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Printer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('printer'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
