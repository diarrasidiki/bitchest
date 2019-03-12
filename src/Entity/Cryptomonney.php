<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CryptomonneyRepository")
 */
class Cryptomonney
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $actualCurrency;

    /**
     * @ORM\Column(type="float")
     */
    private $variationOfDay;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $history;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wallet", mappedBy="cryptomonney")
     */
    private $wallets;

    /**
     * @ORM\Column(type="boolean")
     */
    private $varianceIsInitialisedToday;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastInitDate;

    public function __construct()
    {
        $this->wallets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getActualCurrency(): ?float
    {
        return $this->actualCurrency;
    }

    public function setActualCurrency(float $actualCurrency): self
    {
        $this->actualCurrency = $actualCurrency;

        return $this;
    }

    public function getVariationOfDay(): ?float
    {
        return $this->variationOfDay;
    }

    public function setVariationOfDay(float $variationOfDay): self
    {
        $this->variationOfDay = $variationOfDay;

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(string $history): self
    {
        $this->history = $history;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Wallet[]
     */
    public function getWallets(): Collection
    {
        return $this->wallets;
    }

    public function addWallet(Wallet $wallet): self
    {
        if (!$this->wallets->contains($wallet)) {
            $this->wallets[] = $wallet;
            $wallet->addCryptomonney($this);
        }

        return $this;
    }

    public function removeWallet(Wallet $wallet): self
    {
        if ($this->wallets->contains($wallet)) {
            $this->wallets->removeElement($wallet);
            $wallet->removeCryptomonney($this);
        }

        return $this;
    }

    public function getVarianceIsInitialisedToday(): ?bool
    {
        return $this->varianceIsInitialisedToday;
    }

    public function setVarianceIsInitialisedToday(bool $varianceIsInitialisedToday): self
    {
        $this->varianceIsInitialisedToday = $varianceIsInitialisedToday;

        return $this;
    }

    public function getLastInitDate(): ?\DateTimeInterface
    {
        return $this->lastInitDate;
    }

    public function setLastInitDate(\DateTimeInterface $lastInitDate): self
    {
        $this->lastInitDate = $lastInitDate;

        return $this;
    }
}
