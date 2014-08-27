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


use Symfony\Component\HttpFoundation\Response;

class DownloadsController extends BaseController
{
    public function downloadPdfAction($filename, $format)
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

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'".pdf');
        $response->setContent($content);

        // header cache ...

        return $response;
    }
} 
