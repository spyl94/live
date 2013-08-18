<?php

namespace Live\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Live\LessonBundle\Entity\LessonAsk;
use Live\LessonBundle\Form\LessonAskType;

/**
 * LessonAsk controller.
 *
 * @Route("/lessonask")
 */
class LessonAskController extends Controller
{

    /**
     * Lists all LessonAsk entities.
     *
     * @Route("/", name="lessonask")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiveLessonBundle:LessonAsk')->findAll();

        return array(
            'entities' => $entities,
        );
    }

     /**
     * Lists all Lesson entities of a user.
     *
     * @Template()
     */
    public function listAction($user)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('LiveLessonBundle:LessonAsk')->findByCreator($user, array('name' => 'asc', 'level' => 'asc'));
        $form = $this->createForm(new LessonAskType($this->getUser()->getId()), new LessonAsk());

        $deleteForms = array();
        foreach ($entities as $entity) {
            $deleteForms[] = $this->createDeleteForm($entity->getId())->createView();
        }

        return array(
            'entities' => $entities,
            'user'     => $user,
            'form'     => $form->createView(),
            'deleteForms' =>  $deleteForms,
        );
    }

    /**
     * Creates a new LessonAsk entity.
     *
     * @Route("/", name="lessonask_create")
     * @Method("POST")
     * @Template("LiveLessonBundle:LessonAsk:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new LessonAsk();
        $entity->setCreator($this->getUser());
        $form = $this->createForm(new LessonAskType($this->getUser()->getId()), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fos_user_profile_edit'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new LessonAsk entity.
     *
     * @Route("/new", name="lessonask_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new LessonAsk();
        $form   = $this->createForm(new LessonAskType($this->getUser()->getId()), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a LessonAsk entity.
     *
     * @Route("/{id}", name="lessonask_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:LessonAsk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LessonAsk entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing LessonAsk entity.
     *
     * @Route("/{id}/edit", name="lessonask_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:LessonAsk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LessonAsk entity.');
        }

        $editForm = $this->createForm(new LessonAskType($this->getUser()->getId()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing LessonAsk entity.
     *
     * @Route("/{id}", name="lessonask_update")
     * @Method("PUT")
     * @Template("LiveLessonBundle:LessonAsk:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:LessonAsk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LessonAsk entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LessonAskType($this->getUser()->getId()), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lessonask_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a LessonAsk entity.
     *
     * @Route("/{id}", name="lessonask_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiveLessonBundle:LessonAsk')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LessonAsk entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fos_user_profile_edit'));
    }

    /**
     * Creates a form to delete a LessonAsk entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
