<?php

namespace Live\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Live\LessonBundle\Entity\Instrument;
use Live\LessonBundle\Form\InstrumentType;

/**
 * Instrument controller.
 *
 * @Route("/admin/instrument")
 */
class InstrumentController extends Controller
{

    /**
     * Lists all Instrument entities.
     *
     * @Route("/", name="admin_instrument")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LiveLessonBundle:Instrument')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Instrument entity.
     *
     * @Route("/", name="admin_instrument_create")
     * @Method("POST")
     * @Template("LiveLessonBundle:Instrument:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Instrument();
        $form = $this->createForm(new InstrumentType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_instrument_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Instrument entity.
     *
     * @Route("/new", name="admin_instrument_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Instrument();
        $form   = $this->createForm(new InstrumentType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Instrument entity.
     *
     * @Route("/{id}", name="admin_instrument_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:Instrument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instrument entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Instrument entity.
     *
     * @Route("/{id}/edit", name="admin_instrument_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:Instrument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instrument entity.');
        }

        $editForm = $this->createForm(new InstrumentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Instrument entity.
     *
     * @Route("/{id}", name="admin_instrument_update")
     * @Method("PUT")
     * @Template("LiveLessonBundle:Instrument:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LiveLessonBundle:Instrument')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instrument entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new InstrumentType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_instrument_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Instrument entity.
     *
     * @Route("/{id}", name="admin_instrument_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LiveLessonBundle:Instrument')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Instrument entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_instrument'));
    }

    /**
     * Creates a form to delete a Instrument entity by id.
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
