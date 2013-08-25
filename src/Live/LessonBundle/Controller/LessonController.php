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
        $asks = $em->getRepository('LiveLessonBundle:LessonAsk')->findAll();

        return array(
            'entities' => $entities,
            'asks' => $asks,
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
        $entities = $em->getRepository('LiveLessonBundle:Lesson')->findByCreatorOrderedByNameAndLevel($user);
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
