<?php


namespace App\Controller;


use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function uploadPicture(Request $request): Response
    {
        dd('upload method');
        /**
         * @todo: Verify if user is logged and upload picture
         */
    }

    /**
     * @Route("/api/pictures/{id}", name="view_picture", methods={"GET"}, requirements={"id"="[0-9]*"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function viewPicture(Request $request, int $id): Response
    {
        dd('view method');
        /**
         * @todo Show picture and make counter += 1
         */
    }
}