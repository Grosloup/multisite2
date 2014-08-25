<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 22/08/2014
 * Time: 18:10
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

class AccountController extends BaseController
{
    public function myAccountAction(Request $request)
    {
        //TODO AccountController
        die('mon compte');
    }

    public function passwordChangeAction(Request $request)
    {
        //TODO AccountController
        die('change mot de passe');
    }
}
