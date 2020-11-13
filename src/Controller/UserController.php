<?php


namespace App\Controller;


use App\Entity\Picture;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/users/{id}/delete", name="delete_users_picture", methods={"GET"}, requirements={"id"="[0-9]*"})
     */
    public function deleteAllPictures(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $pictures = $em->getRepository(Picture::class)->findBy(['user'=>$user]);
        $count = count($pictures);
        for($i=0; $i<$count;$i++)
        {
            $em->remove($pictures[$i]);
            $em->flush();
        }
    }
}