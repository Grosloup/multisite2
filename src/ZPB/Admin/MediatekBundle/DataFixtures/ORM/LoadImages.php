<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 17:05
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

namespace ZPB\Admin\MediatekBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZPB\Admin\MediatekBundle\Entity\Image;

class LoadImages extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $fs = $this->container->get('filesystem');

        $fs->copy($this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/image1.jpg",$this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/tmp/image1.jpg");
        $fs->copy($this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/image2.jpg",$this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/tmp/image2.jpg");
        $imageCreator = $this->container->get('zpb_imagefactory');

        $image1 = $imageCreator->createImage();
        $filename = $this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/tmp/image1.jpg";
        $image1
            ->setFilename('mon_image_1')
            ->setCopyright('Nicolas Canfrère')
            ->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras facilisis feugiat venenatis. Duis tristique pulvinar metus, a congue nibh blandit vitae.')
            ->file = new UploadedFile($filename, 'image1',null,null,null,true);
        ;
        $image1->upload();
        $this->container->get('zpb_thumbfactory')->resize($image1);
        $manager->persist($image1);

        $image2 = $imageCreator->createImage();
        $filename = $this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/tmp/image2.jpg";
        $image2
            ->setFilename('mon_image_2')

            ->setTitle('Quisque in sem tempor, cursus velit non, congue arcu. Nam fermentum justo nec velit pulvinar, et ornare nunc rhoncus. Aliquam non enim tristique, tincidunt quam sed, rhoncus dolor.')
            ->file = new UploadedFile($filename, 'image2',null,null,null,true);
        ;
        $image2->upload();
        $this->container->get('zpb_thumbfactory')->resize($image2);
        $manager->persist($image2);




        $manager->flush();

        $this->addReference('zpb-media-img-1', $image1);
        $this->addReference('zpb-media-img-2', $image2);

    }
    
    public function getOrder()
    {
        return 1;
    }
}
