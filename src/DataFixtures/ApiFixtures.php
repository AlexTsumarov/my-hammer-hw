<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\JobRequest;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ApiFixtures extends Fixture
{
    const DATA = [
        Location::class   => [
            [10115, 'Berlin'],
            [32457, 'Porta Westfalica'],
        ],
        Category::class   => [
            [804040, 'Sonstige Umzugsleistungen'],
            [802030, 'Abtransport, Entsorgung und Entrümpelung'],
        ],
        JobRequest::class => [
            ['Test job #1', 1, 1, '+1 day', 'Description'],
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $objects = [Location::class => [], Category::class => [], JobRequest::class => []];
        foreach (self::DATA as $class => $arr) {
            foreach ($arr as $data) {
                switch ($class) {
                    case Location::class:
                        $location = new Location;
                        $location->setZip($data[0]);
                        $location->setName($data[1]);
                        $manager->persist($location);
                        $objects[$class][] = $location;
                        break;
                    case Category::class:
                        $category = new Category();
                        $category->setCatId($data[0]);
                        $category->setName($data[1]);
                        $manager->persist($category);
                        $objects[$class][] = $category;
                        break;
                    case JobRequest::class:
                        $jobRequest = new JobRequest();
                        $jobRequest->setTitle($data[0]);
                        $jobRequest->setZip($objects[Location::class][0]);
                        $jobRequest->setCategory($objects[Category::class][0]);
                        $jobRequest->setEndDT((new \DateTime())->modify($data[3]));
                        $jobRequest->setDescription($data[4]);
                        $manager->persist($jobRequest);
                        $objects[$class][] = $jobRequest;
                        break;
                }

            }
        }
        $manager->flush();
    }
}
