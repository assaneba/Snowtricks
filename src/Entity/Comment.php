<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="fk_comment_user1_idx", columns={"user_iduser"}), @ORM\Index(name="fk_comment_tricks1_idx", columns={"tricks_idtricks"})})
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcomment", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcomment;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=255, nullable=false)
     */
    private $content;

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
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     */
    private $published;

    /**
     * @var \Tricks
     *
     * @ORM\ManyToOne(targetEntity="Tricks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tricks_idtricks", referencedColumnName="idtricks")
     * })
     */
    private $trickstricks;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_iduser", referencedColumnName="iduser")
     * })
     */
    private $useruser;

    public function getIdcomment(): ?int
    {
        return $this->idcomment;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getTrickstricks(): ?Tricks
    {
        return $this->trickstricks;
    }

    public function setTrickstricks(?Tricks $trickstricks): self
    {
        $this->trickstricks = $trickstricks;

        return $this;
    }

    public function getUseruser(): ?User
    {
        return $this->useruser;
    }

    public function setUseruser(?User $useruser): self
    {
        $this->useruser = $useruser;

        return $this;
    }


}
