<?php

namespace Live\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Live\LessonBundle\Entity\Lesson;
use Live\LessonBundle\Form\LessonType;

/**
 * Lesson controller.
 *
 * @Route("/lesson")
 */
class LessonController extends Controller
{

    /**
     * Lists all Lesson entities.
     *
     * @Route("/", name="lesson")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiveLessonBundle:Lesson')->findAll();

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
        $entities = $em->getRepository('LiveLessonBundle:Lesson')->findByCreator($user, array('name' => 'asc', 'level' => 'asc'));
        $form = $this->createForm(new LessonType($this->getUser()->getId()), new Lesson());

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
     * Creates a new Lesson entity.
     *
     * @Route("/", name="lesson_create")
     * @Method("POST")
     * @Template("LiveLessonBundle:Lesson:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Lesson();
        $entity->setCreator($this->getUser());
        $form = $this->createForm(new LessonType($this->getUser()->getId()), $entity);
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
     * Displays a form to create a new Lesson entity.
     *
     * @Route("/new", name="lesson_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lesson();
        $form   = $this->createForm(new LessonType($this->getUser()->getId()), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Lesson entity.
     *
     * @Route("/{id}", name="lesson_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Lesson entity.
     *
     * @Route("/{id}/edit", name="lesson_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
        }

        $editForm = $this->createForm(new LessonType($this->getUser()->getId()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Lesson entity.
     *
     * @Route("/{id}", name="lesson_update")
     * @Method("PUT")
     * @Template("LiveLessonBundle:Lesson:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LessonType($this->getUser()->getId()), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lesson_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Lesson entity.
     *
     * @Route("/{id}", name="lesson_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiveLessonBundle:Lesson')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lesson entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fos_user_profile_edit'));
    }

    /**
     * Creates a form to delete a Lesson entity by id.
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
