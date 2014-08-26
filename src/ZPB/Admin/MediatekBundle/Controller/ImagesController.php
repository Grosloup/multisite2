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
use ZPB\Admin\MediatekBundle\Form\Type\ImageUploadType;

class ImagesController extends BaseController
{
    public function listAction($page = 1)
    {
        return $this->render('ZPBAdminMediatekBundle:Images:list.html.twig');
    }

    public function uploadAction(Request $request)
    {
        $image = $this->get('zpb_imagefactory')->createImage();

        $form = $this->createForm(new ImageUploadType(), $image);
        $form->handleRequest($request);
        if($form->isValid()){

        }
        return $this->render('ZPBAdminMediatekBundle:Images:upload.html.twig', ['form'=>$form->createView()]);
    }

    public function deleteAction($id)
    {
        die('delete images');
    }

}
