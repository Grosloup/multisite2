<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 17:10
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

namespace ZPB\Admin\NewsBundle\Service;




use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;

class PostCookie
{

    private $defaultParams = [];
    private $cookieParams = [];
    private $params = [];

    public function __construct(RequestStack $requestStack, $params = [], $cookieParams=[])
    {
        $this->cookieParams = $cookieParams;
        $this->defaultParams = $params;
        $cookie = $requestStack->getMasterRequest()->cookies->get($this->cookieParams['name'], null);
        if($cookie){
            $this->params = array_merge($this->defaultParams, json_decode($cookie, true));
        } else {
            $this->params = $this->defaultParams;
        }
    }

    public function get($key='', $default=null)
    {
        return array_key_exists($key, $this->params) ? $this->params[$key] : $default ;
    }

    public function set($key='', $value = null)
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function makeCookie()
    {
        $cookie = new Cookie(
            $this->cookieParams['name'],
            json_encode($this->params),
            time() + $this->cookieParams['expire'],
            '/',
            $this->cookieParams['domain'],
            false,
            false
        );
        return $cookie;
    }
}
