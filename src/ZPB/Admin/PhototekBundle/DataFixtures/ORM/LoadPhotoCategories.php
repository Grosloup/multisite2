<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 10:53
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

namespace ZPB\Admin\PhototekBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZPB\Admin\PhototekBundle\Entity\PhotoCategory;

class LoadPhotoCategories extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $cat1 = new PhotoCategory();
        $cat1->setName('Les bébés');
        $manager->persist($cat1);

        $cat2 = new PhotoCategory();
        $cat2->setName('Nouveautés');
        $manager->persist($cat2);

        $cat3 = new PhotoCategory();
        $cat3->setName('Mammifères');
        $manager->persist($cat3);

        $cat4 = new PhotoCategory();
        $cat4->setName('Oiseaux');
        $manager->persist($cat4);
        
        $manager->flush();
        
        $this->addReference('zpb-photos-cat-1', $cat1);
        $this->addReference('zpb-photos-cat-2', $cat2);
        $this->addReference('zpb-photos-cat-3', $cat3);
        $this->addReference('zpb-photos-cat-4', $cat4);
    }
    
    public function getOrder()
    {
        return 60;
    }
}
