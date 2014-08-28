<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 10:00
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

namespace ZPB\Admin\PhototekBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use ZPB\Admin\CommonBundle\Controller\BaseController;

class PhotoController extends BaseController
{
    public function listAction($page = 1)
    {
        $photos = $this->getRepo('ZPBAdminPhototekBundle:Photo')->findAll(); //TODO pagination
        return $this->render('ZPBAdminPhototekBundle:Photo:list.html.twig', ['photos'=>$photos]);
    }

    public function uploadAction(Request $request)
    {
        return $this->render('ZPBAdminPhototekBundle:Photo:upload.html.twig', []);
    }
} 
