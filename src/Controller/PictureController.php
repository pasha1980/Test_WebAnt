<?php


namespace App\Controller;


use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function pictureUpload(Request $request)
    {

    }

    /**
     * @Route("/api/pictures/{id}", name="view_picture", methods={"GET"}, requirements={"id"="[0-9]*"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function viewPicture(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $picture = $em->getRepository(Picture::class)->find($id);
        $view = $picture->getViews();
        $view++;
        $picture->setViews($view);

        $em->persist($picture);
        $em->flush();
        dump($picture);
//        $response = json_encode($picture);
//        dd($response);
//        return $response
        dd('');
        // todo Problem
//        dd($this->json($));
    }
}