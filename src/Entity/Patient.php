<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
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
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Prescription::class, mappedBy="patient")
     */
    private $dugIntake;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="userPatient")
     */
    private $users;

    public function __construct()
    {
        $this->dugIntake = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Prescription[]
     */
    public function getDugIntake(): Collection
    {
        return $this->dugIntake;
    }

    public function addDugIntake(Prescription $dugIntake): self
    {
        if (!$this->dugIntake->contains($dugIntake)) {
            $this->dugIntake[] = $dugIntake;
            $dugIntake->setPatient($this);
        }

        return $this;
    }

    public function removeDugIntake(Prescription $dugIntake): self
    {
        if ($this->dugIntake->contains($dugIntake)) {
            $this->dugIntake->removeElement($dugIntake);
            // set the owning side to null (unless already changed)
            if ($dugIntake->getPatient() === $this) {
                $dugIntake->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addUserPatient($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeUserPatient($this);
        }

        return $this;
    }
}
