<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_account")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bug", mappedBy="userBug")
     */
    private $bugs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evolution", mappedBy="userEvolution")
     */
    private $evolutions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="userVote")
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="userComments")
     */
    private $comments;

    public function __construct()
    {
        $this->bugs = new ArrayCollection();
        $this->evolutions = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        if (empty($roles)) $roles[] = 'ROLE_SUPER_ADMIN';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Bug[]
     */
    public function getBugs(): Collection
    {
        return $this->bugs;
    }

    public function addBug(Bug $bug): self
    {
        if (!$this->bugs->contains($bug)) {
            $this->bugs[] = $bug;
            $bug->setUserBug($this);
        }

        return $this;
    }

    public function removeBug(Bug $bug): self
    {
        if ($this->bugs->contains($bug)) {
            $this->bugs->removeElement($bug);
            // set the owning side to null (unless already changed)
            if ($bug->getUserBug() === $this) {
                $bug->setUserBug(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evolution[]
     */
    public function getEvolutions(): Collection
    {
        return $this->evolutions;
    }

    public function addEvolution(Evolution $evolution): self
    {
        if (!$this->evolutions->contains($evolution)) {
            $this->evolutions[] = $evolution;
            $evolution->setUserEvolution($this);
        }

        return $this;
    }

    public function removeEvolution(Evolution $evolution): self
    {
        if ($this->evolutions->contains($evolution)) {
            $this->evolutions->removeElement($evolution);
            // set the owning side to null (unless already changed)
            if ($evolution->getUserEvolution() === $this) {
                $evolution->setUserEvolution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setUserVote($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getUserVote() === $this) {
                $vote->setUserVote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUserComments($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUserComments() === $this) {
                $comment->setUserComments(null);
            }
        }

        return $this;
    }

    public function serialize()
    {

        return serialize()([
            $this->id,
            $this->email,
            $this->roles,
            $this->password
        ]);
    }

    /**
     * @param $serialized
     */
    public function unserialize($serialized)
    {

        list(
            $this->id,
            $this->email,
            $this->roles,
            $this->password
            ) = $this->unserialize($serialized, ['allowed_class' => false]);

    }

    public function _toString()
    {
        return $this->email;
    }
}
