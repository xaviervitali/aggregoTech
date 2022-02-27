<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractFixture extends Fixture
{
    /**
     * instance de $faker qui sera dispo dans toutes nos fixtures
     */
    protected Generator $faker;
    /**
     * instance de l'Object Manager  qui sera dispo dans toutes nos fixtures
     */
    protected ObjectManager $manager;

    /**
     * Function Abstraite qui sera appelée après la function load 
     *
     */
    abstract protected function loadData(ObjectManager $manager);


    /**
     * Initialisation de la Fixture
     *
     */
    final public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_FR');
        $this->customizeFaker();


        $this->loadData($manager);
    }
    /**
     * fonction qui renvoi une référence à une entité créee dansune autre fixture auparavant en precisant la class de l'entité que vous rechercher
     */
    protected function getRandomreference(string $classname)
    {
        $references = $this->referenceRepository->getReferences();
        /**
         * on filtre sur les clés de toutes les références crée dans la méthode addToMany
         */
        $filteredNames = array_filter(
            array_keys($references),
            function ($names) use ($classname) {
                return strpos($names, $classname . '_') === 0;
            }
        );

        if (count($filteredNames) === 0) {
            throw new \Exception("pas de $classname");
        }
        $randomReferenceName = $this->faker->randomElement($filteredNames);
        return $this->getReference($randomReferenceName);
    }
    /**
     * fonction qui permet d'automatiser la creation de fixture en lui injectant
     *le nom de la classe, le nombre d'occurence et un callable qui represente les parametres de remplisage de la table
     * @param string $classname
     * @param integer $count
     * @param callable $callback
     * @return void
     */
    public function createMany(string $classname, int $count, callable $callback)
    {
        for ($i = 0; $i < $count; $i++) {
            $obj = new  $classname;
            $callback($obj, $i);
            $this->manager->persist($obj);
            $this->addReference($classname . '_' . $i, $obj);
        }
        $this->manager->flush();
    }

    protected function customizeFaker(): void
    {
    }
}
