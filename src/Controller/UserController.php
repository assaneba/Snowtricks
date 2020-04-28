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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/manage-users", name="manage-users")
     * @isGranted("ROLE_ADMIN", message="Vous devez vous admin pour modifier cette section !")
     */
    public function manageUsers(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)
                         ->findAllWithoutSuperAdmin();

        return $this->render('user/manage-users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}/delete-user", name="delete-user")
     * @isGranted("ROLE_ADMIN", message="Vous devez vous admin pour modifier cette section !")
     */
    public function deleteAUser(ObjectManager $manager, User $user)
    {
        if ($user) {
            $manager->remove($user);
            $manager->flush();
        }

        return $this->redirectToRoute('manage-users');
    }

    /**
     * @Route("/{id}/change-role", name="change-role")
     * @isGranted("ROLE_ADMIN", message="Vous devez vous admin pour modifier cette section !")
     */
    public function changeRole(ObjectManager $manager, User $user)
    {
        if ($user) {
            if ($user->getRole() === 'ROLE_USER') {
                $user->setRole('ROLE_ADMIN');
            } else {
                $user->setRole('ROLE_USER');
            }

            $manager->flush();
        }

        return $this->redirectToRoute('manage-users');
    }

    /**
     * @Route("/edit-profile", name="edit-profile")
     * @isGranted("ROLE_USER", message="Vous devez vous connecter pour modifier votre profil")
     */
    public function editProfile(Request $request, ObjectManager $manager, UploadFile $uploadFile, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {

            if ($form['profileImage']->getData()) {
                $profileImagePath = $uploadFile->upload($form['profileImage']->getData());
                $user->setProfileImage($profileImagePath);
            }

            $hashedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
