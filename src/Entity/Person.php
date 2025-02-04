<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Imię nie może być puste")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Imię musi mieć co najmniej {{ limit }} znaki",
        maxMessage: "Imię może mieć maksymalnie {{ limit }} znaków"
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(message: "Nazwisko nie może być puste")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Nazwisko musi mieć co najmniej {{ limit }} znaki",
        maxMessage: "Nazwisko może mieć maksymalnie {{ limit }} znaków"
    )]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[Assert\NotBlank(message: "Email nie może być pusty")]
    #[Assert\Email(message: "To nie jest prawidłowy adres email")]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\NotBlank(message: "Telefon nie może być pusty")]
    #[Assert\Length(
        min: 6,
        max: 20,
        minMessage: "Telefon musi mieć co najmniej {{ limit }} znaków",
        maxMessage: "Telefon może mieć maksymalnie {{ limit }} znaków"
    )]
    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->name.' '.$this->lastName;
    }
}