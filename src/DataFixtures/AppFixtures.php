<?php

namespace App\DataFixtures;

use App\Entity\Attendance;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Field;
use App\Entity\FileCategory;
use App\Entity\FileUpload;
use App\Entity\Survey;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends AbstractFixture
{



    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 50, function (User $user, $i) {
            $roles = ["ROLE_ADMIN", "ROLE_EMPLOYEE", "ROLE_USER"];
            $user
                ->setRoles([$this->faker->randomElement($roles)])
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setUsername("user$i")
                ->setPassword("password")
                ->setGender($this->faker->randomElement(["Mme", "M", "N/A"]))
                ->setDescription($this->faker->catchPhrase());
        });




        // $this->createMany(Category::class, 5, function (Category $category, $i) {

        //     $category->setTitle('categorie'.$i)
        //     ->setDescription($this->faker->text(100));


        // });

        //     $this->createMany(Field::class, 10, function (Field $field, $i) {

        //         $field->setTitle('Question'.$i);
        //         for($j=1; $j<rand(1, 3); $j++){
        //         $field->addCategory($this->getRandomreference(Category::class));
        //     }
        // });

        // $this->createMany(Survey::class, 30, function(Survey $survey){
        // $category = $this->getRandomreference(Category::class);
        // $field = $this->getRandomreference(Field::class);
        // $survey->setField($field)
        // ->setAnswer($this->faker->catchPhrase())
        // ->setCategory($category);
        // });

        // $this->createMany(Attendance::class, 50, function(Attendance $attendance){
        //     $date = $this->faker->dateTimeThisMonth();
        //     $immutable = DateTimeImmutable::createFromMutable( $date );
        //     $user = $this->getRandomreference(User::class);
        //     $attendance->setUser($user)
        //     ->setAddedBy($this->getRandomreference(User::class))
        //     ->setCreatedAt($immutable)
        //     ->setUpdatedAt($immutable);
        //     });

        $this->createMany(FileCategory::class, 5, function (FileCategory $fileCategory) {
            /**
             * @var FileCategory $fileCategory
             */
            $fileCategory->setName($this->faker->word());
        });
        $this->createMany(FileUpload::class, 50, function (FileUpload $file) {
            $user = $this->getRandomreference(User::class);
            $category = $this->getRandomreference(FileCategory::class);
            $file->setUser($user)
                ->setDescription($this->faker->text(255))
                ->setTitle($this->faker->text(255))
                // ->setFileUploadedName($this->faker->file())
                ->setFileCategory($category);
        });
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
