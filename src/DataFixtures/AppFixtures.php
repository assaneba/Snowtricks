<?php

namespace App\DataFixtures;

use App\Entity\GroupOfTricks;
use App\Entity\Tricks;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Add the admin user
        $user = new User();
        $password = $this->encoder->encodePassword($user, 'passer12345');
        $user->setLogin('Crow')
            ->setPassword($password)
            ->setFirstName('Assane')
            ->setLastName('Ba')
            ->setEmail('assanetb@gmail.com')
            ->setProfileImage('default-profile.png')
            ->setRole('ROLE_SUPER_ADMIN')
            ;
        $manager->persist($user);

        // Groups of Tricks
        $groupOfTricksArray = array(
            array('id' => '1','name' => 'Groupe 1'),
            array('id' => '2','name' => 'Groupe 2')
        );

        // Tricks
        $trickArray = array(
            array('id' => '1','user_id' => '1','name' => 'Back Flip','description' => '1- Le mieux c’est de s’entrainer à le faire sur un trampoline car le mouvement est le même. 
2- Choisissez un kicker de bord de piste, qui kicke un peu de préférence, pour vous aider à envoyer facilement 
3- Arrivez bien fléchi en appui sur les 2 jambes et fixez le bout du kicker. L’impulsion se fait à 2 pieds au bout du kicker et pas avant : si on envoie trop tôt on risque de taper la tête dans le kicker ou de trop tourner, de faire un tour et demi et de tomber sur la tête. Deux situations à éviter... 
4- Donc impulsion à deux pieds, et on envoie la tête en arrière pour chercher le mouvement. Dès que l’on a décollé il faut remonter les genoux pour enrouler le mouvement. Les profs de gym ont tendance à dire que l’on envoie le mouvement avec le bassin, ce qui n’est pas faux mais c’est surtout quand on a compris le mouvement et que l’on est à l’aise avec. 
5- Donc regrouper les jambes en les montant. A ce moment on peut aussi penser à grabber mais ce n’est pas obligé pour commencer... On continue d’emmener la rotation avec la tête en arrière.','created_at' => '2020-05-03 16:50:19','last_modify_at' => '2020-05-03 16:50:19','default_image' => 'backflip-1-5eaef64b181db.jpeg','slug' => 'back-flip'),
            array('id' => '2','user_id' => '1','name' => 'Front Side','description' => '1 - La phase d’approche consiste à arriver bien fléchi sur le kicker, la planche bien à plat, les épaules dans l’axe de la board, le regard fixé sur le bout du kicker. 2 - L\'impulsion se fait à 2 pieds au bout du kicker. Ne pas pousser trop fort aux premiers essais au risque d’être déséquilibré. Donc impulsion à 2 pieds, en lançant la rotation avec les épaules comme un 5.4 front (voir le tuto) mais il faut les lancer plus vite et donc plus fort, à affiner selon la taille du saut. Pour un Frontside 720, on peut avoir une impulsion bien à plat, en appui léger sur les talons ou encore en appuie pointe de pieds, suivant le style qu\'on veut donner à son tricks et surtout suivant comme on se sent le plus à l’aise de faire. Mais surtout il ne faut déraper le moins possible sur le kicker pour ne pas perdre d’élan, en particulier sur une table de park. 3 - Pour que la rotation se fasse bien à plat il faut lancer le mouvement avec les épaules à l’horizontale et la tête qui va vers l’épaule avant. Pour désaxer, c’est la tête qui va chercher à twister le mouvement et les épaules ne seront plus à l’horizontale. 4 - Dès que l’on est en l’air il faut se regrouper et grabber. Pour commencer je conseille le Melon (voir tuto sur les grabs). Une fois que l’on maitrise bien le mouvement on peut changer de grab. Dans tous les cas, la main de libre va chercher à emmener la rotation et aider à contrôler la vitesse à laquelle on tourne. 5 - Il faut aller chercher la réception du regard par dessus l’épaule avant : on l’aperçoit après 3/4 de tour puis très bien après le premier 360. À ce moment là, ne pas la fixer et continuer de regarder vers l\'épaule pour continuer à emmener la rotation. Enrouler bien le mouvement pour continuer à tourner toujours en allant chercher du regard et en s’aidant de la main qui ne grave pas. À partir de maintenant tout va ce passer comme pour la fin d’un 3.6 front.','created_at' => '2020-05-03 17:25:18','last_modify_at' => '2020-05-03 17:25:18','default_image' => 'front-side-4-5eaefe7ee5955.jpeg','slug' => 'front-side'),
            array('id' => '3','user_id' => '1','name' => 'Double Mc Twist 1260','description' => 'Le Mc Twist est un flip (rotation verticale) agrémenté d\'une vrille. Un saut très périlleux réservé aux professionnels. Le champion précoce Shaun White s\'est illustré par un Double Mc Twist 1260 lors de sa session de Half-Pipe aux Jeux Olympiques de Vancouver en 2010. Nul doute que c\'est cette figure qui lui a valu de remporter la médaille d\'or.','created_at' => '2020-05-03 17:31:21','last_modify_at' => '2020-05-03 17:31:21','default_image' => 'Double-Mc-Twist-1260-5eaeffe93a65a.jpeg','slug' => 'double-mc-twist-1260'),
            array('id' => '4','user_id' => '1','name' => 'Slide','description' => 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.','created_at' => '2020-05-03 17:41:03','last_modify_at' => '2020-05-03 17:41:03','default_image' => 'slide-1-5eaf022fe1af5.jpeg','slug' => 'slide'),
            array('id' => '5','user_id' => '1','name' => 'Double Backflip One Foot','description' => 'Comme on peut le deviner, les "one foot" sont des figures réalisées avec un pied décroché de la fixation. Pendant le saut, le snowboarder doit tendre la jambe du côté dudit pied. L\'esthète Scotty Vine – une sorte de Danny MacAskill du snowboard – en a réalisé un bel exemple avec son Double Backflip One Foot.','created_at' => '2020-05-03 17:44:15','last_modify_at' => '2020-05-03 17:44:15','default_image' => 'Double-Backflip-One-Foot-2-5eaf02efcc6eb.jpeg','slug' => 'double-backflip-one-foot'),
            array('id' => '6','user_id' => '1','name' => 'Method air','description' => 'Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique "old school". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du "air" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut).','created_at' => '2020-05-03 18:52:50','last_modify_at' => '2020-05-03 18:52:50','default_image' => 'Method-air-1-5eaf13022b557.jpeg','slug' => 'method-air'),
            array('id' => '7','user_id' => '1','name' => 'Rocket Air','description' => 'Attrapez l\'avant de la planche et mettez la planche a la verticale.','created_at' => '2020-05-03 18:56:38','last_modify_at' => '2020-05-03 18:56:38','default_image' => 'rocket-air-1-5eaf13e6f2169.jpeg','slug' => 'rocket-air'),
            array('id' => '8','user_id' => '1','name' => 'Nose Slide','description' => 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé. Un nose slide est un slide fait sur l\'avant de la planche.','created_at' => '2020-05-03 18:58:48','last_modify_at' => '2020-05-03 18:58:48','default_image' => 'nose-slide-1-5eaf1468703b3.jpeg','slug' => 'nose-slide'),
            array('id' => '9','user_id' => '1','name' => 'Seat  Belt','description' => 'Saisie du carre frontside à l\'arrière avec la main avant.','created_at' => '2020-05-03 19:01:45','last_modify_at' => '2020-05-03 19:01:45','default_image' => 'seatbelt-1-5eaf1519456e1.jpeg','slug' => 'seat--belt'),
            array('id' => '10','user_id' => '1','name' => 'Stale fish','description' => 'Saisie du carre frontside à l\'arrière avec la main avant.','created_at' => '2020-05-03 19:06:21','last_modify_at' => '2020-05-03 19:06:21','default_image' => 'stalefish-1-5eaf162d4f401.jpeg','slug' => 'stale-fish')
        );

        // Create Groups
        foreach ($groupOfTricksArray as $groupEntry) {
            $group = new GroupOfTricks();
            $group->setName($groupEntry['name']);
            $manager->persist($group);
        }

        // Create Tricks has Groups
        foreach ($trickArray as $trickEntry) {
            $trick = new Tricks();
            $trick->setUser(1)
                  ->setName($trickEntry['name'])
                  ->setDescription($trickEntry['description'])
                  ->setCreatedAt($trickEntry['created_at'])
                  ->setLastModifyAt($trickEntry['last_modify_at'])
                  ->setDefaultImage($trickEntry['default_image'])
                  ->setGroupOfTricks(1)
                  ->setSlug($trickEntry['slug'])
            ;
            $manager->persist($trick);
        }

        $manager->flush();
    }
}
