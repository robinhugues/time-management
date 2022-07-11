<?php

namespace App\DataFixtures;


use Faker;
use App\Entity\Schedule;
use App\Entity\ScheduleType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures  extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // on crée 3 Type d'horaire 
        $scheduleTypes = Array();
        for ($i = 0; $i < 3; $i++) {
            $scheduleTypes[$i] = new ScheduleType();
            $scheduleTypes[$i]->setName($faker->name());
            $manager->persist($scheduleTypes[$i]);
            $manager->flush();
        }

        $types = $manager->getRepository(ScheduleType::class)->findAll();
    
        // on crée 3 horaires 
        $schedules = Array();
        for ($i = 0; $i < 3; $i++) {
            $schedules[$i] = new Schedule();
            $schedules[$i]->setName($faker->name());
            $schedules[$i]->setComment($faker->realText(200));
            $schedules[$i]->setpriority($faker->numberBetween(0, 2));
            $schedules[$i]->setScheduleType($faker->randomElement($types));
            $schedules[$i]->setStartDateTime($faker->dateTime());
            $schedules[$i]->setEndDateTime($faker->dateTime());

            $manager->persist($schedules[$i]);
            $manager->flush();
        }

    }
}
