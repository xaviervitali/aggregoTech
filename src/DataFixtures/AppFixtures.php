<?php



namespace App\DataFixtures;

use App\Entity\Appreciation;
use App\Entity\AppreciationCategory;
use App\Entity\Attendance;

use App\Entity\User;

use App\Entity\Category;

use App\Entity\Field;

use App\Entity\FileCategory;

use App\Entity\FileUpload;
use App\Entity\Level;
use App\Entity\Skill;
use App\Entity\Statement;
use App\Entity\Survey;

use DateTime;

use DateTimeImmutable;

use Doctrine\Persistence\ObjectManager;

use Doctrine\Bundle\FixturesBundle\Fixture;



class AppFixtures extends AbstractFixture

{







    public function loadData(ObjectManager $manager)

    {

        $this->createMany(User::class, 5, function (User $user, $i) {

            $roles = ["ROLE_ADMIN", "ROLE_EMPLOYEE", "ROLE_USER", "ROLE_RH"];

            $user

                ->setRoles([$this->faker->randomElement($roles)])

                ->setFirstName($this->faker->firstName())

                ->setLastName($this->faker->lastName())

                ->setUsername("user$i")

                ->setPassword("password")

                ->setGender($this->faker->randomElement(["Mme", "M", "N/A"]))

                ->setDescription($this->faker->catchPhrase());
        });


        $this->createMany(Level::class, 3, function (Level $level) {
            /**
             * @var Level $level
             */
            $level->setTitle($this->faker->catchPhrase());
        });


        $this->createMany(AppreciationCategory::class, 10, function (AppreciationCategory $appreciationCategory) {
            /**
             * @var AppreciationCategory $appreciationCategory
             */
            $appreciationCategory->setTitle($this->faker->words(3, true));
        });

        $this->createMany(Skill::class, 10, function (Skill $skill) {
            /**
             * @var Skill $skill
             */
            $skill->setTitle($this->faker->words(3, true))
                ->setDescription($this->faker->paragraphs(3, true))
                ->setCategory($this->getRandomreference(AppreciationCategory::class));
        });

        $this->createMany(Statement::class, 10, function (Statement $statement) {
            /**
             * @var Statement $statement
             */

            $statement->setCreatedAt(new DateTimeImmutable($this->faker->date()))
                ->setUser($this->getRandomreference(User::class));
        });

        $this->createMany(Appreciation::class, 10, function (Appreciation $appreciation) {
            /**
             * @var Appreciation $appreciation
             */
            $appreciation
                ->setLevel($this->getRandomreference(Level::class))
                ->setComment($this->faker->paragraphs(3, true))
                ->setSkill($this->getRandomreference(Skill::class))
                ->setStatement($this->getRandomreference(Statement::class));
        });
    }



    public function getDependencies()

    {

        return [UserFixtures::class];
    }
}
