<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={"normalization_context"={"groups"="entity_with_media_list"}}
 *     },
 *     itemOperations={
 *          "get"={"normalization_context"={"groups"="entity_with_media_list"},}
 *     }
 * )
 * @ORM\Entity()
 */
class EntityWithMediaList
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
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="entityWithMediaList")
     *
     * @Groups({"entity_with_media_list"})
     */
    private $mediaList;

    /**
     * EntityWithMediaList constructor.
     */
    public function __construct()
    {
        $this->mediaList = new ArrayCollection();
    }

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
     * @return Collection|Media[]
     */
    public function getMediaList(): Collection
    {
        return $this->mediaList;
    }

    /**
     * @param Media $mediaList
     * @return $this
     */
    public function addMediaToList(Media $mediaList): self
    {
        if (!$this->mediaList->contains($mediaList)) {
            $this->mediaList[] = $mediaList;
            $mediaList->setEntityWithMediaList($this);
        }

        return $this;
    }

    /**
     * @param Media $mediaList
     * @return $this
     */
    public function removeMediaFromList(Media $mediaList): self
    {
        if ($this->mediaList->removeElement($mediaList)) {
            // set the owning side to null (unless already changed)
            if ($mediaList->getEntityWithMediaList() === $this) {
                $mediaList->setEntityWithMediaList(null);
            }
        }

        return $this;
    }
}
