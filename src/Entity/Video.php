<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video", indexes={@ORM\Index(name="fk_video_tricks_idx", columns={"tricks_idtricks"})})
 * @ORM\Entity
 */
class Video
{
    /**
     * @var bool
     *
     * @ORM\Column(name="idvideo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvideo;

    /**
     * @var string
     *
     * @ORM\Column(name="embed", type="string", length=255, nullable=false)
     */
    private $embed;

    /**
     * @var \Tricks
     *
     * @ORM\ManyToOne(targetEntity="Tricks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tricks_idtricks", referencedColumnName="idtricks")
     * })
     */
    private $trickstricks;

    public function getIdvideo(): ?int
    {
        return $this->idvideo;
    }

    public function getEmbed(): ?string
    {
        return $this->embed;
    }

    public function setEmbed(string $embed): self
    {
        $this->embed = $embed;

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
