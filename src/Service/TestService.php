<?php

namespace App\Service;

use App\Entity\EntityWithImage;
use App\Entity\EntityWithMediaAndImage;
use App\Entity\EntityWithMediaList;
use App\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class TestService
 * @package App\Service
 */
class TestService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TestService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Init data.
     */
    public function initData(): void
    {
        $testClasses = self::getTestClasses();
        foreach ($testClasses as $class) {
            $all = $this->entityManager->getRepository($class)->findAll();
            if (count($all) === 0) {
                $this->createFixtures($class);
            }
        }
    }

    /**
     * @param string $class
     */
    public function createFixtures(string $class): void
    {
        switch ($class) {
            case Media::class:
                for ($i = 1; $i <= 4; $i++) {
                    $media = new Media();
                    $media
                        ->setName('Media ' . $i)
                        ->setImageName('media-' . $i . '.jpg');
                    $this->entityManager->persist($media);
                }
                break;
            case EntityWithImage::class:
                for ($i = 1; $i <= 2; $i++) {
                    $entityWithImage = new EntityWithImage();
                    $entityWithImage
                        ->setName('EntityWithImage ' . $i)
                        ->setImageName('entity-with-image-' . $i . '.jpg');
                    $this->entityManager->persist($entityWithImage);
                }
                break;
            case EntityWithMediaList::class:
                for ($i = 1; $i <= 2; $i++) {
                    $entityWithMediaList = new EntityWithMediaList();
                    $mediaName1 = 'Media '.($i === 1 ? 1 : 3);
                    $mediaName2 = 'Media '.($i === 1 ? 2 : 4);
                    $entityWithMediaList
                        ->setName('EntityWithMediaList ' . $i)
                        ->addMediaToList($this->entityManager->getRepository(Media::class)->findOneBy([
                            'name' => $mediaName1
                        ]))
                        ->addMediaToList($this->entityManager->getRepository(Media::class)->findOneBy([
                            'name' => $mediaName2
                        ]));
                    $this->entityManager->persist($entityWithMediaList);
                }
                break;
            case EntityWithMediaAndImage::class:
                for ($i = 1; $i <= 2; $i++) {
                    $entityWithMediaAndImage = new EntityWithMediaAndImage();
                    $mediaName = 'Media '.($i === 1 ? 1 : 2);
                    $entityWithMediaAndImage
                        ->setName('EntityWithMediaAndImage ' . $i)
                        ->setImageName('entity-with-media-and-image-' . $i . '.jpg')
                        ->setMedia($this->entityManager->getRepository(Media::class)->findOneBy([
                            'name' => $mediaName
                        ]));
                    $this->entityManager->persist($entityWithMediaAndImage);
                }
                break;
        }

        $this->entityManager->flush();
    }

    /**
     * @return ObjectRepository[]
     */
    public static function getTestClasses(): array
    {
        return [
            Media::class,
            EntityWithImage::class,
            EntityWithMediaList::class,
            EntityWithMediaAndImage::class,
        ];
    }
}