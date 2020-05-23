<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserFixture
 * @package App\DataFixtures
 */
class UserFixture extends AbstractExampleDataFixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('dummy')
            ->setName('dummy user for example team')
            ->setPlainPassword('dummy')
            ->setTeam($this->getReference(TeamFixture::TEAM_REFERENCE))
            ->addUserRole($manager->getRepository(Role::class)->findOneBy(['dj_role' => 'team']))
            ->addUserRole($manager->getRepository(Role::class)->findOneBy(['dj_role' => 'jury']));

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [TeamFixture::class];
    }
}