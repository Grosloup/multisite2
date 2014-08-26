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
        $imageCreator = $this->container->get('zpb_imagefactory');

        $image1 = $imageCreator->createImage();
        $filename = $this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/image1.jpg";
        $image1
            ->setFilename('mon_image_1')
            ->setCopyright('Nicolas Canfrère')
            ->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras facilisis feugiat venenatis. Duis tristique pulvinar metus, a congue nibh blandit vitae.')
            ->file = new UploadedFile($filename, $filename);
        ;

        $image1->upload();
        $manager->persist($image1);


        $manager->flush();

        $this->addReference('zpb-media-img-1', $image1);

    }
    
    public function getOrder()
    {
        return 1;
    }
}
