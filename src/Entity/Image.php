<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image", indexes={@ORM\Index(name="fk_image_tricks1_idx", columns={"tricks_idtricks"})})
 * @ORM\Entity
 */
class Image
{
    /**
     * @var bool
     *
     * @ORM\Column(name="idimage", type="boolean", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idimage;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var \Tricks
     *
     * @ORM\ManyToOne(targetEntity="Tricks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tricks_idtricks", referencedColumnName="idtricks")
     * })
     */
    private $trickstricks;

    public function getIdimage(): ?bool
    {
        return $this->idimage;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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


}