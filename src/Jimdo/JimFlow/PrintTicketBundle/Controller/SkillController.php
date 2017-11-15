<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Controller;

use Jimdo\JimFlow\PrintTicketBundle\Entity\Skill;
use Jimdo\JimFlow\PrintTicketBundle\Form\Skill as SkillForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;

/**
 * Skill controller.
 */
class SkillController extends Controller
{
    /**
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function indexAction()
    {
        $entities = $this->repository()->findAll();

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Skill:index.html.twig',
            array(
                 'entities' => $entities
            )
        );
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function newAction()
    {
        $skill = new Skill();
        $form = $this->createSkillForm($skill);

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Skill:new.html.twig',
            array(
                 'entity' => $skill,
                 'form' => $form->createView()
            )
        );
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse|\Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function createAction()
    {
        $skill = new Skill();
        $request = $this->getRequest();
        $form = $this->createSkillForm($skill);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->entityManager();

            if ($file = $skill->getImage()) {
                $fileName = $this->get('jimdo.image_upload')->upload($file);

                $skill->setImage($fileName);
            }

            $em->persist($skill);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Created your skill.');

            return $this->redirect($this->generateUrl('skill_edit', array('id' => $skill->getId())));
        }

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Skill:new.html.twig',
            array(
                 'entity' => $skill,
                 'form' => $form->createView()
            )
        );
    }

    /**
     * @throws \Symfony\Bundle\FrameworkBundle\Controller\NotFoundHttpException
     * @param $id
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function editAction($id)
    {
        $imageUpload = $this->get('jimdo.image_upload');
        $em = $this->entityManager();
        $entity = $this->repository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $imageSrc = $imageUpload->getImageSrc($entity->getImage());

        if ($entity->getImage()) {
            $entity->setImage($imageUpload->getFileObject($entity->getImage()));
        }

        $editForm = $this->createSkillForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'JimdoJimFlowPrintTicketBundle:Skill:edit.html.twig',
            array(
                 'entity' => $entity,
                 'edit_form' => $editForm->createView(),
                 'delete_form' => $deleteForm->createView(),
                 'imageSrc' => $imageSrc
            )
        );
    }

    /**
     * @throws \Symfony\Bundle\FrameworkBundle\Controller\NotFoundHttpException
     * @param $id
     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse|\Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function updateAction($id)
    {
        $imageUpload = $this->get('jimdo.image_upload');
        $em = $this->entityManager();

        $entity = $this->repository()->find($id);
        $oldImage = null;

        if ($entity->getImage()) {
            $oldImage = $imageUpload->getFileObject($entity->getImage());
        }

        $entity->setImage($oldImage);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Skill entity.');
        }

        $editForm = $this->createSkillForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            // Don't delete skill image?
            if ($editForm->get('deleteImage')->getData() !== true) {

                // Skill got new image?
                if ($file = $entity->getImage()) {
                    $fileName = $imageUpload->upload($file);

                    $entity->setImage($fileName);

                    if ($oldImage) {
                        $imageUpload->delete($oldImage);
                    }
                } elseif ($oldImage) {
                    $entity->setImage($oldImage->getBaseName());
                }
            }

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Saved your changes.');
            return $this->redirect($this->generateUrl('skill_edit', array('id' => $id)));
        }


        return $this->render(
            'JimdoJimFlow\PrintTicketBundle:Skill:edit.html.twig',
            array(
                 'entity' => $entity,
                 'edit_form' => $editForm->createView(),
                 'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * @throws \Symfony\Bundle\FrameworkBundle\Controller\NotFoundHttpException
     * @param $id
     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
     */
    public function deleteAction($id)
    {
        $imageUpload = $this->get('jimdo.image_upload');
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = $this->repository()->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Skill entity.');
            }

            if ($entity->getImage()) {
                $image = $imageUpload->getFileObject($entity->getImage());

                $imageUpload->delete($image);
            }

            $em = $this->entityManager();
            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', 'Deleted skill');

        return $this->redirect($this->generateUrl('skill_list'));
    }

    /**
     * @param $id
     * @return FormInterface
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                ->add('id', 'hidden')
                ->getForm();
    }

    /**
     * @param $entity
     * @return FormInterface
     */
    private function createSkillForm($entity)
    {
        return $this->createForm(new SkillForm(), $entity);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function entityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function repository()
    {
        $em = $this->entityManager();
        $repository = $em->getRepository('JimdoJimFlowPrintTicketBundle:Skill');

        return $repository;
    }
}
