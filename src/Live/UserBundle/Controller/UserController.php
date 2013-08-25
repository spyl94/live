<?php

namespace Live\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Live\UserBundle\Form\Type\UserAdminType;

class UserController extends Controller
{
    /**
     * @Route("/users", name="users_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('LiveUserBundle:User')->findAll();

        return array(
            'users' => $users,
        );
    }

    /**
     * @Route("/users/{slug}", name="users_view")
     * @Template()
     */
    public function viewAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('LiveUserBundle:User')->findOneByUsernameCanonical($slug);

        if (!$user) {
            throw $this->createNotFoundException('Impossible de trouver cet utilisateur !');
        }
        $lessons = $em->getRepository('LiveLessonBundle:Lesson')->findByCreatorOrderedByNameAndLevel($user);
        $asks = $em->getRepository('LiveLessonBundle:LessonAsk')->findByCreatorOrderedByNameAndLevel($user);

        return array(
            'user' => $user,
            'lessons' => $lessons,
            'asks' => $asks
        );
    }

    /**
     * @Route("admin/users/", name="admin_users")
     * @Template()
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('LiveUserBundle:User')->findAll();

        $forms = array();
        foreach ($users as $user) {
            $forms[] = $this->createForm(new UserAdminType(), $user)->createView();
        }

        return array(
            'users' => $users,
            'forms' => $forms,
        );
    }

    /**
     * @Route("admin/users/{id}", name="admin_users_edit")
     */
    public function adminEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('LiveUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserAdminType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_users'));
    }

    /**
     * @Template()
     */
    public function instrumentsAction($user, $limit, $offset)
    {
        $instruments = $user->getInstruments();

        if ($instruments->isEmpty()) {
            $em = $this->getDoctrine()->getManager();
            $instruments = $em->getRepository('LiveLessonBundle:Instrument')->getInstrumentsLowLevel();
            $user->setInstruments($instruments);
            $em->flush();
        }

        return array(
            'instruments' => $instruments,
            'length' => $limit,
            'start' => $offset,
        );
    }

}
