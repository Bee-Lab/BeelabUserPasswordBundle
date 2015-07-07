<?php

namespace Beelab\UserPasswordBundle\Controller;

use Beelab\UserPasswordBundle\Entity\ResetPassword;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * ResetPasswordController.
 */
class ResetPasswordController extends Controller
{
    /**
     * New password.
     *
     * @Method({"GET", "POST"})
     *
     * @Route("/password/new", name="beelab_new_password")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm('beelab_reset_password');
        if ($form->handleRequest($request)->isValid()) {
            $this->get('event_dispatcher')->dispatch(
                'app.new_password',
                new NewPasswordEvent($user, 'beelab_new_password_confirm')
            );

            return $this->redirectToRoute('beelab_new_password_ok');
        }

        return $this->render('BeelabUserPassword:ResetPassword:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * New password OK.
     *
     * @Method("GET")
     *
     * @Route("/password/new/ok", name="beelab_new_password_ok")
     */
    public function okAction()
    {
        return $this->render('BeelabUserPassword:ResetPassword:ok.html.twig');
    }

    /**
     * Confirm bew password.
     *
     * @Method({"GET", "POST"})
     *
     * @Route("/password/new/confirm/{token}", name="beelab_new_password_confirm")
     */
    public function confirmAction(ResetPassword $resetPassword, Request $request)
    {
        $form = $this->createForm('beelab_new_password');
        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $resetPassword->getUser()->setPlainPassword($data['password']);
            $this->get('beelab_user.manager')->update($resetPassword->getUser(), false);
            $this->getDoctrine()->getManager()->remove($resetPassword);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Password successfully reset.');

            return $this->redirectToRoute('login');
        }

        return $this->render('BeelabUserPassword:ResetPassword:confirm.html.twig', array(
            'form' => $form->createView(),
            'user' => $resetPassword->getUser(),
        ));
    }
}
