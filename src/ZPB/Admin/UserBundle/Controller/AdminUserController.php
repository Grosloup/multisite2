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
use ZPB\Admin\UserBundle\Form\Type\UpdateAdminUserType;

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
            /** @var \ZPB\Admin\UserBundle\Entity\Role $simpleUserRole */
            $simpleUserRole = $this->getRepo('ZPBAdminUserBundle:Role')->findOneByName('user');

            $em = $this->getManager();
            if($simpleUserRole){
                $user->addRole($simpleUserRole);
                /*$simpleUserRole->addUser($user);
                $em->persist($simpleUserRole);*/
            }
            //
            $user->setRegisterBefore(new \DateTime());
            $registerBefore = $user->getRegisterBefore()->format('d/m/Y H:i:s');
            $registerUrl = $this->generateUrl('zpb_admin_user_enable_account', ['activate'=>$activateCode, 'limit'=>$user->getRegisterBefore()->getTimestamp()], UrlGeneratorInterface::ABSOLUTE_URL);

             //TODO email generation
            $em->persist($user);
            $em->flush();

            //envoi de l'email

            return $this->redirect($this->generateUrl('zpb_admin_user_list'));
        }

        return $this->render('ZPBAdminUserBundle:AdminUser:register.html.twig', ['form'=>$form->createView()]);
    }

    public function updateAction($id, Request $request)
    {
        // /utilisateus/modifier/{id} ["POST","GET"]
        //TODO AdminUserController
        $user = $this->getRepo('ZPBAdminUserBundle:AdminUser')->find($id);
        if(!$user){
            throw $this->createNotFoundException(); //TODO custom user not found
        }
        if($user->isSuperAdmin()){
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(new UpdateAdminUserType(), $user);

        $form->handleRequest($request);
        if($form->isValid()){

        }

        return $this->render('ZPBAdminUserBundle:AdminUser:update.html.twig', ['form'=>$form->createView()]);
    }

    public function deleteAction($id, Request $request)
    {
        // /utilisateus/modifier/{id} ["GET"]
        //TODO AdminUserController

        $token = $request->query->get('_token', false);
        if(!$token || !$this->getCsrf()->isCsrfTokenValid('delete_user', $token)){
            throw $this->createAccessDeniedException();
        }
        $user = $this->getRepo('ZPBAdminUserBundle:AdminUser')->find($id);
        if(!$user){
            throw $this->createNotFoundException(); //TODO custom user not found
        }
        if($user->isSuperAdmin()){
            throw $this->createAccessDeniedException();
        }
        $em = $this->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirect($this->generateUrl('zpb_admin_user_list'));
    }

    public function newPasswordAction()
    {
        //TODO AdminUserController
    }
}
