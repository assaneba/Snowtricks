<?php

namespace App\Entity;

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
     * @var \Group
     *
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_idgroup", referencedColumnName="idgroup")
     * })
     */
    private $groupgroup;

    public function getIdtricks(): ?bool
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

    public function getGroupgroup(): ?Group
    {
        return $this->groupgroup;
    }

    public function setGroupgroup(?Group $groupgroup): self
    {
        $this->groupgroup = $groupgroup;

        return $this;
    }


}
