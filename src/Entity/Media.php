<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity()
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"entity_with_media_list"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"entity_with_media_list"})
     */
    private $imageName;

    /**
     * @ORM\ManyToOne(targetEntity=EntityWithMediaList::class, inversedBy="mediaList")
     */
    private $entityWithMediaList;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     * @return $this
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return EntityWithMediaList|null
     */
    public function getEntityWithMediaList(): ?EntityWithMediaList
    {
        return $this->entityWithMediaList;
    }

    /**
     * @param EntityWithMediaList|null $entityWithMediaList
     * @return $this
     */
    public function setEntityWithMediaList(?EntityWithMediaList $entityWithMediaList): self
    {
        $this->entityWithMediaList = $entityWithMediaList;

        return $this;
    }
}
