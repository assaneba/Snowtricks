<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Service\UploadFile;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @param ObjectManager $manager
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * @param ObjectManager $manager
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * @param Request $request
     * @param ObjectManager $manager
     * @param UploadFile $uploadFile
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edit-profile", name="edit-profile")
     * @isGranted("ROLE_USER", message="Vous devez vous connecter pour modifier votre profil")
     */
    public function editProfile(Request $request, ObjectManager $manager, UploadFile $uploadFile)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            if ($form['profileImage']->getData()) {
                $profileImagePath = $uploadFile->upload($form['profileImage']->getData());
                $user->setProfileImage($profileImagePath);
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('user/edit-profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
