<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupOfTricks
 *
 * @ORM\Table(name="groupoftrciks", uniqueConstraints={@ORM\UniqueConstraint(name="name_UNIQUE", columns={"name"})})
 * @ORM\Entity
 */
class GroupOfTricks
{
    /**
     * @var bool
     *
     * @ORM\Column(name="idgroup", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idgroup;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    public function getIdgroup(): ?int
    {
        return $this->idgroup;
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


}
