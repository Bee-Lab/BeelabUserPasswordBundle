<?php

namespace Beelab\UserPasswordBundle\Controller;

use Beelab\UserPasswordBundle\Event\ChangePasswordEvent;
use Beelab\UserPasswordBundle\Event\NewPasswordEvent;
use Beelab\UserPasswordBundle\Form\Type\NewPasswordType;
use Beelab\UserPasswordBundle\Form\Type\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends Controller
{
    /**
     * New password.
     *
     * @Route("/password/new", name="beelab_new_password", methods={"GET", "POST"})
     */
    public function newAction(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordType::class);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->get('event_dispatcher')->dispatch(
                'beelab_user.new_password',
                new NewPasswordEvent($form->getConfig()->getType()->getInnerType()->getUser(), 'beelab_new_password_confirm')
            )
            ;

            return $this->redirectToRoute('beelab_new_password_ok');
        }

        return $this->render('@BeelabUserPassword/ResetPassword/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * New password OK.
     *
     * @Route("/password/new/ok", name="beelab_new_password_ok", methods="GET")
     */
    public function okAction(): Response
    {
        return $this->render('@BeelabUserPassword/ResetPassword/ok.html.twig');
    }

    /**
     * Confirm bew password.
     *
     * @Route("/password/new/confirm/{token}", name="beelab_new_password_confirm", methods={"GET", "POST"})
     */
    public function confirmAction(string $token, Request $request): Response
    {
        $resetPassword = $this->getDoctrine()
            ->getRepository($this->getParameter('beelab_user.password_reset_class'))
            ->findOneByToken($token)
        ;
        if (null === $resetPassword) {
            throw $this->createNotFoundException(sprintf('Token not found: %s', $token));
        }
        $form = $this->createForm(NewPasswordType::class);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->get('event_dispatcher')->dispatch(
                'beelab_user.change_password',
                new ChangePasswordEvent($resetPassword->getUser())
            )
            ;
            $data = $form->getData();
            $resetPassword->getUser()->setPlainPassword($data['password']);
            $this->get('beelab_user.manager')->update($resetPassword->getUser(), false);
            $this->getDoctrine()->getManager()->remove($resetPassword);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Password successfully reset.');

            return $this->redirectToRoute('login');
        }

        return $this->render('@BeelabUserPassword/ResetPassword/confirm.html.twig', [
            'form' => $form->createView(),
            'user' => $resetPassword->getUser(),
        ]);
    }
}
