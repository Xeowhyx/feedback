<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentDesc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evolution", inversedBy="Comments")
     */
    private $evolution;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bug", inversedBy="comment")
     */
    private $bug;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userComments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function __construct()
    {
        $this->setCreated(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCommentDesc(): ?string
    {
        return $this->commentDesc;
    }

    public function setCommentDesc(?string $commentDesc): self
    {
        $this->commentDesc = $commentDesc;

        return $this;
    }


    public function getEvolution(): ?Evolution
    {
        return $this->evolution;
    }

    public function setEvolution(?Evolution $evolution): self
    {
        $this->evolution = $evolution;

        return $this;
    }

    public function getBug(): ?Bug
    {
        return $this->bug;
    }

    public function setBug(?Bug $bug): self
    {
        $this->bug = $bug;

        return $this;
    }

    public function getUserComments(): ?User
    {
        return $this->userComments;
    }

    public function setUserComments(?User $userComments): self
    {
        $this->userComments = $userComments;

        return $this;
    }

    public function setCreated()
    {
        $this->created = new \DateTime('now');
    }

    /**
     * @return \DateTime
    */
    public function getCreated()
    {
        return $this->created;
    }
}
