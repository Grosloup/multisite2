<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 22/08/2014
 * Time: 18:09
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
use ZPB\Admin\CommonBundle\Controller\BaseController;

class LoginController extends BaseController
{
    public function loginAction(Request $request)
    {
        // /login ["GET"]
        //TODO LoginController
    }

    public function activationAction(Request $request)
    {
        $activationId = $request->query->get('activate', false);
        $activationLimitDate = $request->query->get('limit', false);

        if(!$activationId || !$activationLimitDate ){
            throw $this->createAccessDeniedException(); //TODO message d'erreur spécifique
        }

        /** @var \ZPB\Admin\UserBundle\Entity\AdminUser $user */
        $user = $this->getRepo('ZPBAdminUserBundle:AdminUser')->findOneByActivationCode($activationId);

        if(!$user){
            throw $this->createNotFoundException(); //TODO message d'erreur spécifique
        }

        $registerBefore = $user->getRegisterBefore();
        $now = new \DateTime();

        if($now > $registerBefore){
            throw $this->createAccessDeniedException(); //TODO message d'erreur spécifique
        }


        // form avec $user + changer mot de passe

        //form validé
            //mot de passe est changé
            //isActive true
            //activationCode effacé
            //activatedAt est set
    }
}
