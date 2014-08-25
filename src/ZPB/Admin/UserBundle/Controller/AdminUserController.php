<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 10:42
 */
 /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/

namespace ZPB\Admin\UserBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use ZPB\Admin\CommonBundle\Controller\BaseController;
use ZPB\Admin\UserBundle\Entity\AdminUser;
use ZPB\Admin\UserBundle\Form\Type\AdminUserType;

class AdminUserController extends BaseController
{
    public function listAction()
    {
        // /utilisateurs ["GET"]
        //TODO AdminUserController
        $users = $this->getRepo('ZPBAdminUserBundle:AdminUser')->findBy([], ['firstname'=>'ASC']);
        return $this->render('ZPBAdminUserBundle:AdminUser:list.html.twig', ['users'=>$users]);
    }

    public function registerAction(Request $request)
    {
        // /utilisateus/ajouter ["POST","GET"]
        //TODO AdminUserController
        $user = new AdminUser();
        if(!$user->getPlainPassword()){
            $user->setPlainPassword($this->getRepo('ZPBAdminUserBundle:AdminUser')->generatePassword());
        }

        $form = $this->createForm(new AdminUserType(), $user);

        $form->handleRequest($request);

        if($form->isValid()){
            $plainPassword = $user->getPlainPassword();
            $activateCode = $user->getActivationCode();
            $user->setRegisterBefore(new \DateTime());
            $registerBefore = $user->getRegisterBefore()->format('d/m/Y H:i:s');
            $registerUrl = $this->generateUrl('zpb_admin_user_enable_account', ['activate'=>$activateCode, 'limit'=>$user->getRegisterBefore()->getTimestamp()], UrlGeneratorInterface::ABSOLUTE_URL);
            var_dump($plainPassword, $activateCode, $registerBefore, $registerUrl);die();
            //$em = $this->getManager(); //TODO email generation
            //$em->persist($user);
            //$em->flush();

            //envoi de l'email

            return $this->redirect($this->generateUrl('zpb_admin_user_list'));
        }

        return $this->render('ZPBAdminUserBundle:AdminUser:register.html.twig', ['form'=>$form->createView()]);
    }

    public function updateAction($id, Request $request)
    {
        // /utilisateus/modifier/{id} ["POST","GET"]
        //TODO AdminUserController
    }

    public function deleteAction($id, Request $request)
    {
        // /utilisateus/modifier/{id} ["GET"]
        //TODO AdminUserController
    }

    public function newPasswordAction()
    {
        //TODO AdminUserController
    }
}
