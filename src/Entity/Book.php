<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'books')]
class Book
{

    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(name: 'title', type: 'string', length: 300)]
    #[Assert\NotBlank()]
    private ?string $title = null;

    #[ORM\Column(name: 'date_of_publication', type: 'date')]
    private ?\DateTimeInterface $dateOfPublication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDateOfPublication(): ?\DateTimeInterface
    {
        return $this->dateOfPublication;
    }

    public function setDateOfPublication(\DateTimeInterface $dateOfPublication): self
    {
        $this->dateOfPublication = $dateOfPublication;

        return $this;
    }
}
