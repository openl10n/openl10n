<?php

namespace Openl10n\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\UserBundle\Entity\User;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\FullName;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User(new Slug('user'));
        $user
            ->setDisplayName(new Name('User'))
            ->setEmail(new Email('user@example.org'))
            ->setPreferedLocale(new Locale('fr-FR'))
        ;

        $john = new User(new Slug('john'));
        $john
            ->setDisplayName(new Fullname('John', 'Doe'))
            ->setEmail(new Email('john.doe@example.org'))
            ->setPreferedLocale(new Locale('en-US'))
        ;

        $this->addReference('user_user', $user);
        $this->addReference('user_john', $john);

        $manager->persist($user);
        $manager->persist($john);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
