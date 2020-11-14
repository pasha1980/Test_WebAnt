<?php


namespace App\Controller;


use App\Entity\Picture;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
//    /**
//     * @param Request $request
//     * @return Response
//     */
//    public function pictureUpload(Request $request)
//    {
//        $serializer = SerializerService::getJsonObjectSerializer();
//        $em = $this->getDoctrine()->getManager();
//
//        $picture = $serializer->deserialize($request->getContent(), Picture::class, 'json');
//        $em->persist($picture);
//        $em->flush();
//    }

    /**
     * @Route("/api/pictures/{id}", name="view_picture", methods={"GET"}, requirements={"id"="[0-9]*"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function viewPicture(Request $request, int $id): Response
    {
        $serializer = SerializerService::getJsonObjectSerializer();
        $em = $this->getDoctrine()->getManager();
        $picture = $em->getRepository(Picture::class)->find($id);
        $view = $picture->getViews();
        $view++;
        $picture->setViews($view);

        $em->persist($picture);
        $em->flush();

        $jsonPicture = $serializer->serialize($picture, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response();
        $response->setContent($jsonPicture);

        return $response;
    }
}