<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use function dump;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register1", name="register")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new \DateTime());

            $hashedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login1", name="login")
     */
    public function login()
    {

        return $this->render('security/login1.html.twig');
    }

    /**
     * @Route("/logout1", name="logout")
     */
    public function logout() {}

}
