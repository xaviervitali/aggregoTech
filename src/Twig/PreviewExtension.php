<?php



namespace App\Twig;

use App\Entity\FileCategory;
use App\Entity\FileUpload;
use Exception;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;

use Twig\TwigFilter;



class PreviewExtension extends AbstractExtension

{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function getFilters()

    {

        return [

            new TwigFilter('preview', [$this, 'showPreview']),

            new TwigFilter('icon', [$this, 'icon']),
            new TwigFilter('card', [$this, 'card']),
            new TwigFilter('fileCategory', [$this, 'fileCategory']),


        ];
    }



    public function showPreview($vichFile)

    {

        $absoluteUrl = "assets/vichFiles/$vichFile";

        try {

            $mimeContent = mime_content_type($absoluteUrl);



            if (str_contains($mimeContent, "image")) {



                return "<img src='/$absoluteUrl' style=' width: 250px; object-fit: cover;' alt='$vichFile'>";
            }



            if (str_contains($mimeContent, "video")) {

                return <<<VIDEO

                <video controls width="250" autoplay>

                

                <source src="/$absoluteUrl"

                type= "$mimeContent">

                

                

                

                Sorry, your browser doesn't support embedded videos.

                </video>

                

                VIDEO;
            }



            if (str_contains($mimeContent, "application/pdf")) {



                return '<i class="fas fa-file-pdf fs-1" style="color:red;"></i>';
            }



            if (str_contains($mimeContent, "word") || str_contains($mimeContent, "text")) {



                return '<i class="far fa-file-word fs-1"  style="color:blue;"></i>';
            }



            if (str_contains($mimeContent, "powerpoint") || str_contains($mimeContent, "powerpoint")) {



                return '<i class="far fa-file-powerpoint fs-1"  style="color:orange;"></i>';
            }

            if (str_contains($mimeContent, "excel") || str_contains($mimeContent, "sheet")) {



                return '<i class="far fa-file-excel fs-1"  style="color:green;"></i>';
            }



            return '<i class="far fa-file-archive fs-1"  style="color:yellow;"></i>';
        } catch (Exception $e) {

            return '<i class="far fa-question-circle fs-1"></i>';
        }
    }



    public function icon($text)

    {

        $icons = [

            'Présentiel' => '<i class="fa-solid fa-handshake fa-2xl"></i>',

            'Appel Téléphonique' => '<i class="fa-solid fa-phone fa-2xl"></i>',

            'Visio' => ' <i class="fa-solid fa-headset fa-2xl"></i>',

            'Mail' => '<i class="fa-solid fa-envelope fa-2xl"></i>',

            'Courrier Postal' => '<i class="fa-solid fa-mailbox "></i>',



        ];



        return $icons[$text];
    }

    function fileCategory(?FileCategory $category)
    {
        if ($category) {
            return ucfirst($category->getName());
        } else {

            return "Non classé";
        }
    }

    function card(FileUpload $file)
    {
        $fileName = $file->getFileUploadedName();
        $fileUploadedPreview = $this->showPreview($fileName);

        $title = $file->getTitle();
        $description = $file->getDescription();
        $updatedAt = date_format($file->getUpdatedAt(), "d/m/Y");
        $title = $file->getTitle();
        $by = $file->getUser()->getFirstname() . " " . $file->getUser()->getLastname();
        $id = $file->getId();

        $remove = "";
        if ($this->security->isGranted("ROLE_ADMIN") || $this->security->isGranted("ROLE_RH") || $this->security->getUser() == $file->getUser()) {
            $remove = '<a href="/profile/file/delete/' . $id . '" class="text-danger">Supprimer</a>';
        }

        $card =
            <<<Card
                <div class="card m-2 py-2 text-center" style="width: 250px">
                <p class="overflow-hidden  d-flex flex-column justify-content-center" style="height: 100px;">$fileUploadedPreview</p>
                <div class="card-body">
                <p class="card-title"><strong>$title</strong></p>
                <p class="card-text">$description</p>
                <p class="card-text">Téléversé le $updatedAt par $by</p>
                <p class="card-text">
                    <a href="/assets/vichFiles/$fileName" target="_blank" >Visualiser</a>
                    $remove
                </p>
                </div>
            </div> 
            Card;


        return $card;
    }
}
