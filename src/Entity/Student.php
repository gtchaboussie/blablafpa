<?php

namespace App\Entity;

use App\Entity\Role;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"id"}, message="Un autre utilisateur s'est déjà inscrit avec ce numéro d'étudiant Afpa, merci de le modifier.")
 */
class Student implements UserInterface
{
    //=================================================================
    //     ATTRIBUTS
    //=================================================================

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Vous devez renseigner votre numéro de stagiaire attribué par l'Afpa.")
     */
    private $studentId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $studentFirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $studentLastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $studentMail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={"image/jpeg", "image/jpg", "image/png"})
     */
    private $studentPicture;

    /**
     * @ORM\Column(type="integer")
     */
    private $studentPhone;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas correctement confirmé votre mot de passe !")
     */
    public $confirmPassword;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $studentDescription;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface", message="Attention, la date d'arrivée doit être au bon format !")
     * @Assert\GreaterThan("today", message="La date d'arrivée doit être ultérieure à la date d'aujourd'hui.")
     */
    private $studentStartDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface", message="Attention, la date de départ doit être au bon format !")
     * @Assert\GreaterThan(propertyPath="studentStartDate", message="La date de départ doit être plus éloignée que la date d'arrivée !")
     */
    private $studentEndDate;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="students")
     */
    private $studentRoles;

    /**
     * @ORM\OneToMany(targetEntity=Lift::class, mappedBy="student", orphanRemoval=true)
     */
    private $lifts;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="student", orphanRemoval=true)
     */
    private $bookings;

    public function __construct()
    {
        $this->studentRoles = new ArrayCollection();
        $this->lifts = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    //=================================================================
    //     SETTERS AND GETTERS
    //=================================================================

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

    public function getStudentFirstName(): ?string
    {
        return $this->studentFirstName;
    }

    public function setStudentFirstName(string $studentFirstName): self
    {
        $this->studentFirstName = $studentFirstName;

        return $this;
    }

    public function getStudentLastName(): ?string
    {
        return $this->studentLastName;
    }

    public function setStudentLastName(string $studentLastName): self
    {
        $this->studentLastName = $studentLastName;

        return $this;
    }

    public function getFullName()
    {
        return "{$this->studentFirstName} {$this->studentLastName}";
    }

    public function getStudentMail(): ?string
    {
        return $this->studentMail;
    }

    public function setStudentMail(string $studentMail): self
    {
        $this->studentMail = $studentMail;

        return $this;
    }

    public function getStudentPicture(): ?string
    {
        return $this->studentPicture;
    }

    public function setStudentPicture(string $studentPicture): self
    {
        $this->studentPicture = $studentPicture;

        return $this;
    }

    public function getStudentPhone(): ?int
    {
        return $this->studentPhone;
    }

    public function setStudentPhone(int $studentPhone): self
    {
        $this->studentPhone = $studentPhone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStudentDescription(): ?string
    {
        return $this->studentDescription;
    }

    public function setStudentDescription(string $studentDescription): self
    {
        $this->studentDescription = $studentDescription;

        return $this;
    }

    public function getStudentStartDate(): ?\DateTimeInterface
    {
        return $this->studentStartDate;
    }

    public function setStudentStartDate(
        \DateTimeInterface $studentStartDate
    ): self {
        $this->studentStartDate = $studentStartDate;

        return $this;
    }

    public function getStudentEndDate(): ?\DateTimeInterface
    {
        return $this->studentEndDate;
    }

    public function setStudentEndDate(\DateTimeInterface $studentEndDate): self
    {
        $this->studentEndDate = $studentEndDate;

        return $this;
    }

    //===========================================================
    //   IMPLEMENTATION DE USER INTERFACE
    //===========================================================

 
    public function getRoles()
    {
        $roles = $this->studentRoles
            ->map(function ($role) {
                return $role->getTitle();
            })
            ->toArray();

        $roles[] = 'ROLE_USER';

        return $roles;
    }
    /**
     * @return Collection|Role[]
     */
    public function getStudentRoles()
    {
        return $this->studentRoles;
    }

    public function addStudentRole(Role $studentRole): self
    {
        if (!$this->studentRoles->contains($studentRole)) {
            $this->studentRoles[] = $studentRole;
            $studentRole->addStudent($this);
        }

        return $this;
    }

    public function removeStudentRole(Role $studentRole): self
    {
        if ($this->studentRole->removeElement($studentRole)) {
            $studentRole->removeStudent($this);
        }

        return $this;
    }

    public function getSalt()
    {
        //inutile ici, Bcrypt gère le salt pour nous.
    }

    public function getUsername()
    {
        return $this->studentId;
    }

    public function eraseCredentials()
    {
        //inutile pour nous vu la configuration de notre application
    }

    //Gestion des annonces de trajets//
    /**
     * @return Collection|Lift[]
     */
    public function getLifts()
    {
        return $this->lifts;
    }

    public function addLift(Lift $lift): self
    {
        if (!$this->lifts->contains($lift)) {
            $this->lifts[] = $lift;
            $lift->setStudent($this);
        }

        return $this;
    }

    public function removeLift(Lift $lift): self
    {
        if ($this->lifts->removeElement($lift)) {
            // set the owning side to null (unless already changed)
            if ($lift->getStudent() === $this) {
                $lift->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings()
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setStudent($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getStudent() === $this) {
                $booking->setStudent(null);
            }
        }

        return $this;
    }
}
