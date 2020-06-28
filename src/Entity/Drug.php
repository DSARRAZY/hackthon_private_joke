<?php

namespace App\Entity;

use App\Repository\DrugRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DrugRepository::class)
 */
class Drug
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Prescription::class, inversedBy="drugs")
     */
    private $medicamentPrescription;

    public function __construct()
    {
        $this->medicamentPrescription = new ArrayCollection();
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
     * @return Collection|Prescription[]
     */
    public function getMedicamentPrescription(): Collection
    {
        return $this->medicamentPrescription;
    }

    public function addMedicamentPrescription(Prescription $medicamentPrescription): self
    {
        if (!$this->medicamentPrescription->contains($medicamentPrescription)) {
            $this->medicamentPrescription[] = $medicamentPrescription;
        }

        return $this;
    }

    public function removeMedicamentPrescription(Prescription $medicamentPrescription): self
    {
        if ($this->medicamentPrescription->contains($medicamentPrescription)) {
            $this->medicamentPrescription->removeElement($medicamentPrescription);
        }

        return $this;
    }
}
