<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 10:20
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

namespace ZPB\Admin\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZPB\Admin\UserBundle\Entity\Role;

class LoadRoles extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    function load(ObjectManager $manager)
    {
        $role1 = new Role();
        $role1->setName('superadmin');
        $role1->setReadableName('Super Administrateur');
        $manager->persist($role1);

        $role2 = new Role();
        $role2->setName('admin');
        $role2->setReadableName('Administrateur');
        $manager->persist($role2);

        $role3 = new Role();
        $role3->setName('user');
        $role3->setReadableName('Simple utilisateur');
        $manager->persist($role3);

        $manager->flush();

        $this->addReference('zpb-admin-role-1', $role1);
        $this->addReference('zpb-admin-role-2', $role2);
        $this->addReference('zpb-admin-role-3', $role3);
    }

    public function getOrder()
    {
        return 10;
    }
}
