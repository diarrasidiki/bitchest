<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Avatar;
use App\Entity\Wallet;
use App\Entity\Cryptomonney;
use App\Entity\Role;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


    
class SuperAdminController extends AbstractController
{   
    /**
     * @Route("/admin", name="super_admin")
     * @IsGranted("ROLE_ADMIN")
     */ 
    public function Superadmin(ObjectManager $manager, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $newUser = new User;
        $form = $this->createForm(UserType::class, $newUser);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $roleRepo = $this->getDoctrine()->getRepository(Role::class);
            
            //encryptage du password
            $hash = $encoder->encodePassword($newUser, $newUser->getPassword());
            $newUser->setPassword($hash);

            $cryptos = $this->getDoctrine()->getRepository(Cryptomonney::class)->findAll();  
            foreach($cryptos as $crypto)
            {
                $wallet = new Wallet();
                $wallet->setUser($newUser)
                ->setQuantity(0)
                ->setCryptomonney($crypto);
                $manager->persist($wallet);

            }
                
            $avatar = new Avatar;
            $picture = 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png';
            $avatar->setName($picture)
                    ->setUser($newUser);               
            $manager->persist($avatar);

            if($form->getData()->getAdminChoice() == false)
            {                
                ($newUser->addRole($roleRepo->findOneByTitle('ROLE_USER')));
                $newUser->setAdminChoice(0);
            }
            else
            {
                $newUser->addRole($roleRepo->findOneByTitle('ROLE_USER'));
                $newUser->addRole($roleRepo->findOneByTitle('ROLE_ADMIN'));
                $newUser->setAdminChoice(1);
            }
            
            $manager->persist($newUser);

            $manager->flush();

            $this->addFlash(
                'success',
                'L\'enregistrement a bien été effectué'
            );
        }
        $user = $this->getUser();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/admin.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'users' => $users
            ]);
    }

    /**
     * @Route("/admin-user-edit/{email}", name="super_admin_updateUser")
     * @IsGranted("ROLE_ADMIN")
     */ 
    public function updateUser(User $userUpdate, ObjectManager $manager, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(UserType::class, $userUpdate);
        $userUp = clone $userUpdate;

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {       
            $path = $this->getParameter('uploads_directory');
            $userForm = $form->getData();

            $hash = $encoder->encodePassword($userForm, $userForm->getPassword());
            $userForm->setPassword($hash);

            $roleRepo = $this->getDoctrine()->getRepository(Role::class);
            if($form->getData()->getAdminChoice() == false)
            {                
                $userForm->addRole($roleRepo->findOneByTitle('ROLE_USER'));
                if(!is_null($roleRepo->findOneByTitle('ROLE_ADMIN')))
                {
                    $userForm->removeRole($roleRepo->findOneByTitle('ROLE_ADMIN'));
                }
            }
            else
            {
                $userForm->addRole($roleRepo->findOneByTitle('ROLE_USER'));
                $userForm->addRole($roleRepo->findOneByTitle('ROLE_ADMIN'));
            }

            if($userForm->getFunds() == NULL)
            {
                $userForm->setFunds($userUp->getFunds());
            }
            
            $avatar = $userForm->getAvatar();
            if(!is_null($avatar->getFIle()))
            {           
                $file = $avatar->getFile();
                // $manager->remove($avatar);
                // $manager->flush();
                // $avatar = new Avatar;

                $name = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($path, $name);
                $avatar->setName($name)
                        ->setUser($userForm);

                $userForm->setAvatar($avatar);
                $manager->persist($avatar);
            }

            foreach($userUp->getWallets() as $wallet)
            {
                $userUp->addWallet($wallet);
                // dd($wallet);
            }
            // dd($preserveWallets);
            // dd($userUp->getWallets());
            $manager->flush();

            $this->addFlash(
                'success',
                'l\'utilisateur a bien été mis à jour'
            );
            
            return $this->redirectToRoute(
                'super_admin',
                ['email' => $userUp->getEmail()
            ]);
        }

        return $this->render('admin/admin-update.html.twig', [
            'form' => $form->createView(),
            'userUpdate' => $userUpdate,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/admin-deleteUser/{email}", name="super_admin_deleteUser")
     * @Security("is_granted('ROLE_ADMIN') and user !== deleteUpdate", message="Ce profil n'est effaçable que par son propriétaire!")
     */ 
    public function deleteUser(User $deleteUpdate, ObjectManager $manager)
    {
        $manager->remove($deleteUpdate);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a bien été supprimé'
            );

        return $this->redirectToRoute('super_admin');
    }
}