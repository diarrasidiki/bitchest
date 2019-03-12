<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="connexion")
     */ 
    public function connexion(AuthenticationUtils $utils)
    {
        if($this->getUser() !== NULL)
        {
            // $this->addFlash(
            //     'danger',
            //     'Vous êtes connecté...'
            // );
            return $this->redirectToRoute('backend_portefeuille');
        }
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('home/connexion.html.twig', [
            'hasError' => $error !== null,
            'username' => $username,
        ]);
    }
}
