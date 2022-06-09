<?php



namespace App\Twig;

use App\Entity\FileCategory;
use App\Entity\FileUpload;
use Doctrine\ORM\Query\Expr\Func;
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

            new TwigFilter('preview', [$this, 'preview']),
            new TwigFilter('icon', [$this, 'icon']),
            new TwigFilter('card', [$this, 'card']),
            new TwigFilter('fileCategory', [$this, 'fileCategory']),


        ];
    }

    public function preview($vichFile)
    {
        $assets = "assets";
        $folders = scandir($assets);
        $url = "";
        $embed = "<embed src='%s'  type='%s'>";
        foreach ($folders as $folder) {
            if (file_exists($assets . "/" . $folder . "/" . $vichFile)) {
                $url =  $assets . "/" . $folder . "/" . $vichFile;
            }
        }
        if ($url) {
            $mimeContent = mime_content_type($url);

            return sprintf($embed, "/" . $url, $mimeContent);
        }
        return '<i class="far fa-question-circle fs-1"></i>';
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
        $fileUploadedPreview = $this->preview($fileName);

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
