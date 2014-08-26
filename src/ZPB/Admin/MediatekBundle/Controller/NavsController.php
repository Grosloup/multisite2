<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 16:00
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


use ZPB\Admin\CommonBundle\Controller\BaseController;

class NavsController extends BaseController
{
    public function mainSidebarAction($active_mainsidebar)
    {
        return $this->render('ZPBAdminMediatekBundle:Navs:mainsidebar.html.twig', ['active_mainsidebar'=>$active_mainsidebar]);
    }
} 
