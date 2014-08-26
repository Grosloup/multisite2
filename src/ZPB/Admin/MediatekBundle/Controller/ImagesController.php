<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 22/08/2014
 * Time: 18:27
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

namespace ZPB\Admin\MediatekBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use ZPB\Admin\CommonBundle\Controller\BaseController;

class ImagesController extends BaseController
{
    public function listAction($page = 1)
    {
        return $this->render('ZPBAdminMediatekBundle:Images:list.html.twig');
    }

    public function uploadAction(Request $request)
    {
        return $this->render('ZPBAdminMediatekBundle:Images:upload.html.twig');
    }

    public function deleteAction($id)
    {
        die('delete images');
    }

}
