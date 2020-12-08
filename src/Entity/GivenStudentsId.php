<?php

namespace App\Entity;

use App\Repository\GivenStudentsIdRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GivenStudentsIdRepository::class)
 */
class GivenStudentsId
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $studentId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): self
    {
        $this->studentId = $studentId;

        return $this;
    }
}
