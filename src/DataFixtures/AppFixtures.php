<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Avatar;
use App\Entity\Role;
use App\Entity\Wallet;
use App\Tools\Currency;
use App\Entity\Cryptomonney;
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
        $currency = new Currency();
        
        $monney = ['bitcoin', 'ethereum', 'ripple', 'bitcoin-cash', 'cardano', 'litecoin', 'NEM', 'stellar', 'iota', 'dash'];
        $serial = [];
        $wallObj = [];

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $userRole = new Role();
        $userRole->setTitle('ROLE_USER');
        $manager->persist($userRole);
        
        $user = new User();
        $password = $this->encoder->encodePassword($user, 'azerty');
        $user->setFirstName('Diarra')
            ->setLastName('SIDIKI')
            ->setEmail('test@email.fr')
            ->setPassword($password)
            ->setFunds(1500)
            ->setAdminChoice(1)
            ->addRole($adminRole)        
            ->addRole($userRole);        
        $manager->persist($user);
        
        $avatar = new Avatar;
        $picture = 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png';
        $avatar->setName($picture)
                ->setUser($user);               
        $manager->persist($avatar);
               
        
        for($i=0; $i<10; $i++)
        {
            $crypto = new Cryptomonney();
            $crypto->setName($monney[$i])
            ->setActualCurrency($currency->getFirstCotation($monney[$i]))
            ->setVariationOfDay($currency->getCotationFor($monney[$i]))
            ->setHistory($currency->generateHistory($monney[$i], 100))
            ->setLastInitDate(new \Datetime('now', new \DateTimeZone('Europe/Paris')))
            ->setVarianceIsInitialisedToday(0)
            ->setDescription("Le $monney[$i] (de l'anglais bit : unité d'information binaire et coin « pièce de monnaie ») est une cryptomonnaie autrement appelée monnaie cryptographique. Dans le cas de la dénomination unitaire, on l'écrit « bitcoin » et, dans le cas du système de paiement pair-à-pair on l'écrit « Bitcoin ». L'idée fut présentée pour la première fois en novembre 2008 par une personne, ou un groupe de personnes, sous le pseudonyme de Satoshi Nakamoto1,2. Le code source de l'implémentation de référence fut quant à lui publié en 2009.")
            ;
            
            $manager->persist($crypto);
            $cryptos[] = $crypto;
            
            $wallet = new Wallet();
            $wallet->setUser($user)
                    ->setQuantity(0)//rand(150, 1000)
                    ->setCryptomonney($crypto);
            $manager->persist($wallet);
        }
        
        for($i = 1; $i <= 5; $i++)
        {
            $newUser = new User();
            $password = $this->encoder->encodePassword($user, 'azerty');
            $newUser->setFirstName('PrénomUser'.$i)
            ->setLastName('NomUser'.$i)
            ->setEmail('User'.$i.'@email.fr')
            ->setPassword($password)
            ->setFunds(rand(750, 2000))
            ->setAdminChoice(0)
            ->addRole($userRole);            
            $manager->persist($newUser);

            $avatar = new Avatar;
            $picture = 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png';
            $avatar->setName($picture)
                    ->setUser($newUser);               
            $manager->persist($avatar);
            
            foreach($cryptos as $crypto)
            {
                $wallets = new Wallet();
                $wallets->setUser($newUser)
                ->setQuantity(0)//rand(150, 1000)
                ->setCryptomonney($crypto);
                $manager->persist($wallets);
            }
        }

        $manager->flush();
    }
}
