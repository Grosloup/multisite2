<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 20/08/2014
 * Time: 21:05
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

namespace ZPB\Admin\CommonBundle\Controller;


class NavsController extends BaseController
{
    public function topnavAction($activeMainMenu = "")
    {
        return $this->render('ZPBAdminCommonBundle:Navs:topnav.html.twig', ['active_main_menu'=>$activeMainMenu]);
    }
}
