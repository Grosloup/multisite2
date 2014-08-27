<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 27/08/14
 * Time: 17:47
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


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DownloadsController extends BaseController
{
    public function downloadPdfAction($filename, Request $request)
    {
        $pdf = $this->getRepo('')->findOneByFilename($filename);
        if(!$pdf){
            throw $this->createNotFoundException(); //TODO PDF not found
        }

        $pdf->setCounter($pdf->getCounter() + 1);

        $this->getManager()->persist($pdf);
        $this->getManager()->flush();

        $absPath = $pdf->getAbsolutePath();
        $content = file_get_contents($absPath);
        $response = new Response();

        $response->setLastModified($pdf->getUpdatedAt());
        $response->headers->set('Cache-Control', 'must-revalidate');
        $response->setMaxAge(3600);
        $response->setSharedMaxAge(3600);
        if($response->isNotModified($request)){
            return $response;
        }

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename.'.pdf');
        $response->headers('Content-Length', filesize($absPath));
        $response->setContent($content);



        return $response;
    }
}
