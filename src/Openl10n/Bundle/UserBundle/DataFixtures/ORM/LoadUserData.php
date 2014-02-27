<?php

namespace Openl10n\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\UserBundle\Entity\User;
use Openl10n\Domain\User\Value\Email;
use Openl10n\Domain\User\Value\Username;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User(new Username('user'));
        $user
            ->setName(new Name('User'))
            ->setEmail(new Email('user@example.org'))
            ->setPreferedLocale(Locale::parse('fr-FR'))
        ;

        $john = new User(new Username('johndoe'));
        $john
            ->setName(new Name('John Doe'))
            ->setEmail(new Email('john.doe@example.org'))
            ->setPreferedLocale(Locale::parse('en-US'))
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
