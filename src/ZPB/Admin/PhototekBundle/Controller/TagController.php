<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 14:32
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
use ZPB\Admin\PhototekBundle\Entity\PhotoTag;

class TagController  extends BaseController
{
    public function listAction($page = 1)
    {
        $tags = $this->getRepo('ZPBAdminPhototekBundle:PhotoTag')->findAll(); //TODO pagination ?
        return $this->render('ZPBAdminPhototekBundle:Tag:list.html.twig',['tags'=>$tags]);
    }

    public function newAction(Request $request)
    {
        $tags = new PhotoTag();

        return $this->render('ZPBAdminPhototekBundle:Tag:new.html.twig',['form'=>'']);
    }

    public function editAction($id, Request $request)
    {
        $tag = $this->getRepo('ZPBAdminPhototekBundle:PhotoTag')->find($id);

        return $this->render('ZPBAdminPhototekBundle:Tag:edit.html.twig',['form'=>'']);
    }

    public function deleteAction($id, Request $request)
    {
        $tag = $this->getRepo('ZPBAdminPhototekBundle:PhotoTag')->find($id);

        return $this->redirect($this->generateUrl('zpb_admin_photos_tags_list'));
    }
}
