<?php


namespace App\Controller;


use App\Entity\Localization;
use App\Repository\LocalitzationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class LocalizationController extends ApiController
{

    /**
     * @Route("/api/localization", methods="GET")
     * @param Request $request
     * @param LocalitzationRepository $localizationRepository
     * @return Response
     */
    public function getAllLocalizations(Request $request, LocalitzationRepository $localizationRepository): Response {

        return $this->respond($localizationRepository->transformAll());
    }

    /**
     * @Route("/api/localization", methods="POST")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return mixed
     */
    public function createLocalization(Request $request, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (! $request->get('city')) {
            return $this->respondValidationError('Please provide a title!');
        }

        // persist the new movie
        $localization = new Localization();
        $localization->setCity($request->get('city'));
        $localization->setDistrict($request->get('district'));
        $localization->setCoordinates($request->get('coordinates'));
        $em->persist($localization);
        $em->flush();

        return $this->respondCreated('CREATED');
    }

    /**
     * @param $id
     * @param LocalitzationRepository $localizationRepository
     * @param EntityManagerInterface $em
     * @return Symfony\Component\HttpFoundation\JsonResponse|JsonResponse
     */
    public function deleteLocalization($id, LocalitzationRepository $localizationRepository, EntityManagerInterface $em) {

        $localization = $localizationRepository->find($id);

        if(!$localization) {
            return $this->respondNotFound();
        }

        $em->remove($localization);
        $em->flush();

        return $this->respond('OK');

    }

    /**
     * @param $id
     * @param Request $request
     * @param LocalitzationRepository $localizationRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function updateLocalization($id, Request $request, LocalitzationRepository $localizationRepository, EntityManagerInterface $em): Response
    {


        $localization = $localizationRepository->find($id);

        if(!$localization) {
            return $this->respondNotFound();
        }

        $request = $this->transformJsonBody($request);

        $localization->setCity($request->get('city'));
        $localization->setDistrict($request->get('district'));
        $localization->setCoordinates($request->get('coordinates'));

        $em->persist($localization);
        $em->flush();

        return $this->respondCreated('UPDATED');
    }

}