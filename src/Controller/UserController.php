<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use function dump;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class UserController extends AbstractController
{
    /**
     * @Route("/manage-users", name="manage-users")
     *
     * @isGranted("ROLE_ADMIN", message="Vous devez vous admin pour modifier cette section !")
     *
     */
    public function manageUsers(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();

        //dump($users);

        return $this->render('user/manage-users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}/delete-user", name="delete-user")
     *
     * @isGranted("ROLE_ADMIN", message="Vous devez vous admin pour modifier cette section !")
     *
     */
    public function deleteAUser(ObjectManager $manager, User $user)
    {
        if($user)
        {
            $manager->remove($user);
            $manager->flush();
        }

        return $this->redirectToRoute('manage-users');
    }

    /**
     * @Route("/{id}/change-role", name="change-role")
     *
     * @isGranted("ROLE_ADMIN", message="Vous devez vous admin pour modifier cette section !")
     *
     */
    public function changeRole(ObjectManager $manager, User $user)
    {
        if($user)
        {
            if($user->getRole() == 'ROLE_USER')
            {
                $user->setRole('ROLE_ADMIN');
            }
            else {
                $user->setRole('ROLE_USER');
            }
            $manager->persist($user);
            $manager->flush();
        }

        return $this->redirectToRoute('manage-users');
    }

}
