<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/08/2014
 * Time: 13:58
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
use ZPB\Admin\UserBundle\Entity\AdminUser;

class LoadAdminUsers extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new AdminUser();
        $user1
            ->setCivilite('Mr')
            ->setFirstname('Nicolas')
            ->setLastname('Canfrère')
            ->setEmail('nico.canfrere@gmail.com')
            ->setUsername('nicolas')
            ->setPlainPassword('nicolas')
            ->addRole($this->getReference('zpb-admin-role-1'))
            ->setIsActive(true)
        ;
        $manager->persist($user1);

        $user2 = new AdminUser();
        $user2
            ->setCivilite('Mme')
            ->setFirstname('Aurélie')
            ->setLastname('Canfrère')
            ->setEmail('lili.canfrere@gmail.com')
            ->setUsername('lilie')
            ->setPlainPassword('lilie')
            ->addRole($this->getReference('zpb-admin-role-2'))
            ->setIsActive(true)
        ;
        $manager->persist($user2);

        $user3 = new AdminUser();
        $user3
            ->setCivilite('Mr')
            ->setFirstname('Frédéric')
            ->setLastname('Canfrère')
            ->setEmail('fred.canfrere@gmail.com')
            ->setUsername('fred')
            ->setPlainPassword('fred')
            ->addRole($this->getReference('zpb-admin-role-3'))
            ->setIsActive(true)
        ;
        $manager->persist($user3);


        $manager->flush();

        $this->addReference('zpb-admin-user-1', $user1);
        $this->addReference('zpb-admin-user-2', $user2);
        $this->addReference('zpb-admin-user-3', $user3);

    }

    public function getOrder()
    {
        return 15;
    }
}
