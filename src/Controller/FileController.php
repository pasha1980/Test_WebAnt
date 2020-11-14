<?php


namespace App\Controller;


use App\Entity\File;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{

    /**
     * @Route("/api/files/upload", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function fileUpload(Request $request): Response
    {
        $serializer = SerializerService::getJsonObjectSerializer();

        $data = $serializer->decode($request->getContent(), 'json');

        $content = $data['content'];
        $name = $data['name'];
        $path = $data['path'];

//      OR:
//
//        $content = $request->request->get('content');
//        $name = $request->request->get('name');
//        $path = $request->request->get('path');

        $file = new File();
        $file->setPath($path);
        $file->setName($name);
        die;

        $succes = file_put_contents(
            str_replace('src/Controller','',__DIR__) . 'upload/' . $path . $name,
            $content);

        $response = new Response();
        if($succes) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();
            $response->setContent('Upload succesfull');
        } else {
            $response->setContent('Upload was interrupted');
        }

        return $response;

    }
}