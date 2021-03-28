<?php


namespace App\Controller;


use App\Entity\Project;
use App\Repository\LocalitzationRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends ApiController
{
    public function getAllProjects(Request $request,  ProjectRepository $projectRepository): Response {

        return $this->respond($projectRepository->transformAll());
    }

    /**
     * @param Request $request
     * @param LocalitzationRepository $localizationRepository
     * @param EntityManagerInterface $em
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createProject(Request $request, LocalitzationRepository $localizationRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        echo $request;

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        if (! $request->get('name')) {
            return $this->respondValidationError('Please provide a title!');
        }

        $project = new Project();
        $project->setName($request->get('name'));
        $project->setDescription($request->get('description'));

        $localizationId = $request->get('district');
        if(!$localizationId) {
            return $this->respondValidationError('District can not be null!');
        }

        $localization = $localizationRepository->findBy(array('district' => $request->get('district')))[0];

        if(!$localization) {
            return $this->respondNotFound('Localization not found');
        }

        $project->setLocalization($localization);
        $em->persist($project);
        $em->flush();

        return $this->respondCreated('CREATED');
    }


    /**
     * @param $id
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param LocalitzationRepository $localizationRepository
     * @param EntityManagerInterface $em
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateProject($id,
                                  Request $request,
                                  ProjectRepository $projectRepository,
                                  LocalitzationRepository $localizationRepository,
                                  EntityManagerInterface $em)
    {

        $project = $projectRepository->find($id);
        if(!$project) {
            return $this->respondNotFound();
        }

        $request = $this->transformJsonBody($request);
        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        if (! $request->get('name')) {
            return $this->respondValidationError('Invalid data!');
        }

        $name = $request->get('name');
        if($name) {
            $project->setName($name);
        }

        $description = $request->get('description');
        if($name) {
            $project->setDescription($description);
        }

        $localizationId = $request->get('district');
        if(!$localizationId) {
            return $this->respondValidationError('District can not be null!');
        }

        $localization = $localizationRepository->findBy(array('district' => $request->get('district')))[0];

        if(!$localization) {
            return $this->respondNotFound('Localization not found');
        }

        $project->setLocalization($localization);
        $em->persist($project);
        $em->flush();

        return $this->respondCreated('CREATED');
    }


    public function deleteProject($id, ProjectRepository $projectRepository, EntityManagerInterface $em) {

        $project = $projectRepository->find($id);

        if(!$project) {
            return $this->respondNotFound();
        }

        $em->remove($project);
        $em->flush();

        return $this->respond('OK');

    }
}