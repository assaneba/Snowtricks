<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tricks
 *
 * @ORM\Table(name="tricks", uniqueConstraints={@ORM\UniqueConstraint(name="name_UNIQUE", columns={"name"})}, indexes={@ORM\Index(name="fk_tricks_group1_idx", columns={"group_idgroup"})})
 * @ORM\Entity
 */
class Tricks
{
    /**
     * @var bool
     *
     * @ORM\Column(name="idtricks", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtricks;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modify_at", type="datetime", nullable=false)
     */
    private $lastModifyAt;

    /**
     * @var string
     *
     * @ORM\Column(name="default_image", type="string", length=255, nullable=false)
     */
    private $defaultImage;

    /**
     * @var \GroupOfTricks
     *
     * @ORM\ManyToOne(targetEntity="GroupOfTricks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_idgroup", referencedColumnName="idgroup")
     * })
     */
    private $groupgroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="tricks")
     *  * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_idimage", referencedColumnName="idimage")
     * })
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages() : Collection
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images): void
    {
        $this->images = $images;
    }

    public function getIdtricks(): ?int
    {
        return $this->idtricks;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastModifyAt(): ?\DateTimeInterface
    {
        return $this->lastModifyAt;
    }

    public function setLastModifyAt(\DateTimeInterface $lastModifyAt): self
    {
        $this->lastModifyAt = $lastModifyAt;

        return $this;
    }

    public function getDefaultImage(): ?string
    {
        return $this->defaultImage;
    }

    public function setDefaultImage(string $defaultImage): self
    {
        $this->defaultImage = $defaultImage;

        return $this;
    }

    public function getGroupgroup(): ?GroupOfTricks
    {
        return $this->groupgroup;
    }

    public function setGroupgroup(?GroupOfTricks $groupgroup): self
    {
        $this->groupgroup = $groupgroup;

        return $this;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setTrick($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getTrick() === $this) {
                $image->setTrick(null);
            }
        }

        return $this;
    }


}
