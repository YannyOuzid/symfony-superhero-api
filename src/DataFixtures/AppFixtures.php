<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use App\Entity\User;
use App\Entity\Villain;
use App\Repository\UserRepository;
use App\Repository\VillainRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    private UserRepository $userRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository, VillainRepository $villainRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        $this->villainRepository = $villainRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $apiUrl = 'https://superheroapi.com/api/4782317181828176';
        $clientArray = [];
        $heroArray = [];
        $villainArray = [];

        $professor = new User();
        $professor->setEmail('professorX@email.com');
        $professor->setPassword($this->passwordHasher->hashPassword($professor, 'password'));
        $professor->setRoles(['ROLE_ADMIN']);
        $professor->setName(json_decode(file_get_contents($apiUrl . '/527'))->name);
        $manager->persist($professor);

        $i = 1;

        while (count($heroArray) <= 25) {
            if (json_decode(file_get_contents($apiUrl . '/' . $i))->biography->alignment === 'good') {
                $hero = new User();
                $hero->setEmail('hero' . $i . '@email.com');
                $hero->setPassword($this->passwordHasher->hashPassword($hero, 'password'));
                $hero->setRoles(['ROLE_SUPER_HERO']);
                $hero->setName(json_decode(file_get_contents($apiUrl . '/' . $i))->name);
                array_push($heroArray, $hero);
                $manager->persist($hero);
            }
            $i++;
        }

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 15; $i++) {
            $client = new User();
            $client->setEmail($faker->lastName . $i . '@email.com');
            $client->setPassword($this->passwordHasher->hashPassword($client, 'password'));
            $client->setRoles(['ROLE_CLIENT']);
            $client->setName($faker->firstName);

            array_push($clientArray, $client);

            $manager->persist($client);
        }

        $i = 1;

        while (count($villainArray) <= 50) {
            if (json_decode(file_get_contents($apiUrl . '/' . $i))->biography->alignment === 'bad') {
                $villain = new Villain();
                $villain->setName(json_decode(file_get_contents($apiUrl . '/' . $i))->name);
                array_push($villainArray, $villain);
                $manager->persist($villain);
            }
            $i++;
        }

        for ($i = 1; $i <= 5; $i++) {
            $mission = new Mission();
            $priority = array("Low", "Medium", "High");
            $status = array("To review", "In progress", "Done", "To do");
            $mission->setName('mission' . $i);
            $mission->setDescription('description' . $i);
            $mission->setDate(new \DateTime('now'));
            $mission->setClient($clientArray[$i]);
            $mission->setPriority($priority[array_rand($priority)]);
            $mission->setReleaseDate(new \DateTime(null));
            $mission->setStatut($status[array_rand($status)]);
            $mission->addWicked($villainArray[$i]);
            $mission->addHero($heroArray[$i]);
            $manager->persist($mission);
        }

        $manager->flush();
    }

}
