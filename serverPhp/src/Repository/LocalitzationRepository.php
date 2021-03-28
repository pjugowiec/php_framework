<?php

namespace App\Repository;

use App\Entity\Localization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Localization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localization[]    findAll()
 * @method Localization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalitzationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localization::class);
    }

    public function transform(Localization $localization)
    {
        return [
            'id'    => (int) $localization->getId(),
            'city' => (string) $localization->getCity(),
            'district' => (string) $localization->getDistrict(),
            'coordinates' => (string) $localization->getCoordinates()
        ];
    }

    public function transformAll()
    {
        $localizations = $this->findAll();
        $returnArray = [];

        foreach ($localizations as $localization) {
            $returnArray[] = $this->transform($localization);
        }

        return $returnArray;
    }
}
