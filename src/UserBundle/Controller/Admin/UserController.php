<?php

namespace UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Category controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_admin_user")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');

        return array(
            'users' => $userManager->findUsers(),
        );
    }

    /**
     * @Route("/new", name="user_admin_user_new")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function newAction(Request $request)
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');

        $process = $formHandler->process($confirmationEnabled = false);

        if ($process) {
            $this->addFlash('success', 'registration.flash.user_created');

            return $this->redirectToRoute('user_admin_user', array());
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}", name="user_admin_user_edit")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     * @Method({"GET", "PUT"})
     */
    public function editAction(User $user, Request $request)
    {
        if (!is_object($user)) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('user_admin_user_edit', array('id' => $user->getId())),
            'method' => 'PUT',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a été mis à jour.");

            return $this->redirectToRoute('user_admin_user');
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
