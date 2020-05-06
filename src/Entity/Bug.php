<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\BugRepository")
 *  @Vich\Uploadable
 */
class Bug
{

    /**
     * @ORM\Column(type="string", length=255, nullable= true)
     *
     * @var string
     *
     */
    private $imageName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="bugs", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="date", nullable= true)
     */
    private $updatedAt;



    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @ORM\Column(type="string", length=500)
     */
    private $description;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Priority", inversedBy="bugs",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $priority;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Severity", inversedBy="bugs",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $severity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\State", inversedBy="bugs",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)

     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="bug", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bugs")
     *
     */
    private $userBug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="bugs",cascade={"persist"})
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Os", inversedBy="bugs",cascade={"persist"})
     */
    private $os;

    public function __construct()
    {

        $this->comments = new ArrayCollection();
        $this->setDate(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
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
     * @return \DateTime
     */

    public function getDate()
    {
       return $this->date;

    }
    public function setDate()
    {
        $this->date = new \DateTime('now');

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




    public function getPriority(): ?priority
    {
        return $this->priority;
    }

    public function setPriority(?priority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getSeverity(): ?severity
    {
        return $this->severity;
    }

    public function setSeverity(?severity $severity): self
    {
        $this->severity = $severity;

        return $this;
    }

    public function getState(): ?state
    {
        return $this->state;
    }

    public function setState(?state $state): self
    {
        $this->state = $state;

        return $this;
    }


    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComments(Comments $comments): self
    {
        if (!$this->comments->contains($comments)) {
            $this->comments[] = $comments;
            $comments->setBug($this);
        }

        return $this;
    }

    public function removeComments(Comments $comments): self
    {
        if ($this->comments->contains($comments)) {
            $this->comments->removeElement($comments);
            // set the owning side to null (unless already changed)
            if ($comments->getBug() === $this) {
                $comments->setBug(null);
            }
        }

        return $this;
    }


    public function getUserBug(): ?User
    {
        return $this->userBug;
    }

    public function setUserBug(?User $userBug): self
    {
        $this->userBug = $userBug;

        return $this;
    }

    public function getSlug(): string
    {
        $slug = new Slugify();
        return $slug->slugify($this->name);
    }

    public function _toString()
    {
        return $this->name;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return \DateTime
     */

    public function getUpdatedAt()
    {
        return $this->updatedAt;

    }
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');

    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOs(): ?Os
    {
        return $this->os;
    }

    public function setOs(?Os $os): self
    {
        $this->os = $os;

        return $this;
    }

}
