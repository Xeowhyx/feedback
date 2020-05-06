<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Evolution;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Evolution", cascade={"persist"}, inversedBy="vote")
     */
    private $evolution;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likes;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dislikes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="votes")
     */
    private $userVote;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $userLikeTab = array();

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $userDislikeTab = array();

    /**
     * @return mixed
     */
    public function getUserVote()
    {
        return $this->userVote;
    }

    /**
     * @param mixed $userVote
     */
    public function setUserVote($userVote): void
    {
        $this->userVote = $userVote;
    }


    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvolution(): Evolution
    {
        return $this->evolution;
    }

    public function setEvolution(Evolution $evolution): void
    {
        $this->evolution = $evolution;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(?int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    public function getUserLikeTab(): ?array
    {
        return $this->userLikeTab;
    }

    public function setUserLikeTab($userLikeTab): self
    {
        $this->userLikeTab[] = $userLikeTab;

        return $this;
    }

    public function removeUserLikeTab($key){

        unset($this->userLikeTab[$key]);
        return $this;
    }

    public function getUserDislikeTab(): ?array
    {
        return $this->userDislikeTab;
    }

    public function setUserDislikeTab($userDislikeTab): self
    {
        $this->userDislikeTab[] = $userDislikeTab;

        return $this;
    }

    public function removeUserDislikeTab($key){

        unset($this->userDislikeTab[$key]);
        return $this;
    }

    public function _toString()
    {
        return $this->id;
    }
}


