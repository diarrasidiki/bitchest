<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WalletRepository")
 */
class Wallet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="wallets", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cryptomonney", inversedBy="wallets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cryptomonney;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DateBuy", mappedBy="wallet")
     */
    private $dateBuys;

    public function __construct()
    {
        $this->dateBuys = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCryptomonney(): ?Cryptomonney
    {
        return $this->cryptomonney;
    }

    public function setCryptomonney(?Cryptomonney $cryptomonney): self
    {
        $this->cryptomonney = $cryptomonney;

        return $this;
    }

    /**
     * @return Collection|DateBuy[]
     */
    public function getDateBuys(): Collection
    {
        return $this->dateBuys;
    }

    public function addDateBuy(DateBuy $dateBuy): self
    {
        if (!$this->dateBuys->contains($dateBuy)) {
            $this->dateBuys[] = $dateBuy;
            $dateBuy->setWallet($this);
        }

        return $this;
    }

    public function removeDateBuy(DateBuy $dateBuy): self
    {
        if ($this->dateBuys->contains($dateBuy)) {
            $this->dateBuys->removeElement($dateBuy);
            // set the owning side to null (unless already changed)
            if ($dateBuy->getWallet() === $this) {
                $dateBuy->setWallet(null);
            }
        }

        return $this;
    }
}
