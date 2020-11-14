<?php


namespace App\Controller;


use App\Entity\Picture;
use App\Entity\User;
use App\Security\Authenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserController extends AbstractController
{
    /**
     * @Route("/api/users/{id}/delete", name="delete_users_picture", methods={"GET"}, requirements={"id"="[0-9]*"})
     */
    public function deleteAllPictures(Request $request, int $id): Response
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

        $response = new Response();
        $response->setContent('All user\'s picture have been successfully deleted' );
        return $response;
    }

    /**
     * @Route("/api/register", name="user_register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();

        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $roles[] = 'ROLE_USER';

        $user->setPassword($passwordEncoder->encodePassword($user, $password));
        $user->setEmail($email);
        $user->setRoles($roles);

        $confirmationCode = md5($email, true);
        $user->setConfCode($confirmationCode);
        $user->setConfirmed(false);

        $to = $email;
        $subject = "Регистрация на localhost:8000";
        $message = "<h1>Подтверждение регистрации на localhost:8000</h1><br>
                       <p>Вы отправили запрос на регистрацию на сервисе localhost:8000</p><br>
                       <p>Для подтвердения регистрации перейдите по <a href='http://localhost:8000/confirm/" . $confirmationCode . "'>этой ссылке</a> </p>";
        $header = "Content-type: text/html; charset=iso-8859-1\r\n";
        mail($to, $subject, $message, $header);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $response = new Response();
        $response->setContent('Email was sent');
        return $response;

    }

    /**
     * @Route("/confirm/{confirmationCode}", methods={"GET"})
     */
    public function confirmRegistration(Request $request, string $confirmationCode, GuardAuthenticatorHandler $guardHandler, Authenticator $authenticator)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(["confCode"=>$confirmationCode]);
        if (!$user) {
            return new \InvalidArgumentException('There is no such user');
        }

        $user->setConfirmed(true);
        return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
    }
}