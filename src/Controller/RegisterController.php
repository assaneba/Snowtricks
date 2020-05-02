<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UploadFile;
use Doctrine\Common\Persistence\ObjectManager;
use function dump;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function registration(Request $request, ObjectManager $manager, UploadFile $uploadFile, UserPasswordEncoderInterface $encoder)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('edit-profile');
        }
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new \DateTime());

            if ($form['profileImage']->getData()) {
                $profileImagePath = $uploadFile->upload($form['profileImage']->getData());
                $user->setProfileImage($profileImagePath);
            }
            else {
                $user->setProfileImage('default-profile.png');
            }

            $hashedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
