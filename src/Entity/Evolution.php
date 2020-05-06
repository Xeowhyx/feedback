<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvolutionRepository")
 */
class Evolution
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
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="evolution", cascade={"persist", "remove"})
     */
    private $comments;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="evolutions")
     *
     */
    private $userEvolution;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Vote", cascade={"persist", "remove"})
     */
    private $vote;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->setDate(new \DateTime());
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



    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;

    }

    public function setDate()
    {
        $this->date = new DateTime('now');


    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComments(comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEvolution($this);
        }

        return $this;
    }

    public function removeComments(comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getEvolution() === $this) {
                $comment->setEvolution(null);
            }
        }

        return $this;
    }


    public function getUserEvolution(): ?User
    {
        return $this->userEvolution;
    }

    public function setUserEvolution(?User $userEvolution): self
    {
        $this->userEvolution = $userEvolution;

        return $this;
    }

    public function getSlug(): string
    {
        $slug = new Slugify();
        return $slug->slugify($this->name);
    }

    /**
     * @return mixed
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param mixed $vote
     * @return Evolution
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
        return $this;
    }

    public function _toString()
    {
        return $this->name;
    }


}
