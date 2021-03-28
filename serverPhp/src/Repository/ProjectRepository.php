<?php

namespace App\Repository;

use App\Entity\Localization;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function transform(Project $project): array
    {
        return [
            'id'    => (int) $project->getId(),
            'name' => (string) $project->getName(),
            'description' => (string) $project->getDescription(),
            'localization' => $this->transformLocalization($project->getLocalization())

        ];
    }

    public function transformAll(): array
    {
        $projects = $this->findAll();
        $returnArray = [];

        foreach ($projects as $project) {
            $returnArray[] = $this->transform($project);
        }

        return $returnArray;
    }

    public function transformLocalization(Localization $localization): array
    {
        return [
            'id'    => (int) $localization->getId(),
            'city' => (string) $localization->getCity(),
            'district' => (string) $localization->getDistrict(),
            'coordinates' => (string) $localization->getCoordinates()
        ];
    }
}
