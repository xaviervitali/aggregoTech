<?php



namespace App\Twig;

use App\Entity\FileCategory;
use App\Entity\FileUpload;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;

use Twig\TwigFilter;

class PreviewExtension extends AbstractExtension

{
    private $security;
    private $folders;
    private $url;

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
        if (!$vichFile) {
            return " <img src='/assets/img/user/default.jpg' alt='Pas d avatar' class='logocarte'>";
        }
        $knownMimeContent = [
            "video" => <<<VIDEO
        <video controls autoplay>
        <source src="/%s"
        type= "%s">
        Sorry, your browser doesn't support embedded videos.
        </video>
        
        VIDEO,
            "application/pdf" => '<i class="fas fa-file-pdf" style="color:red;"></i>',
            "word" => '<i class="far fa-file-word"  style="color:blue;"></i>',
            "text" => '<i class="far fa-file-word"  style="color:blue;"></i>',
            "powerpoint" => '<i class="far fa-file-powerpoint"  style="color:orange;"></i>',
            "sheet" => '<i class="far fa-file-excel"  style="color:green;"></i>',
            "application" => '<i class="far fa-file-archive"  style="color:yellow;"></i>',
            "image" => "<img src='%s'>"
        ];
        $finder = new Finder;
        $finder->name($vichFile);
        $url = "";
        foreach ($finder->in("assets")->exclude(["css", "js", "fonts"]) as $file) {
            $url = str_replace('\\', '/', "assets/" . $file->getRelativePathname());
            if ($url) {
                $mimeContent = mime_content_type($url);
                foreach ($knownMimeContent as $mime => $string) {
                    if (str_contains($mimeContent, $mime)) {

                        return sprintf($string, "/$url", $mimeContent);
                    }
                }
            }
        };
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

        $modifyString = "";
        if ($this->security->isGranted("ROLE_ADMIN") || $this->security->isGranted("ROLE_RH") || $this->security->getUser() == $file->getUser()) {
            $modifyString = '<a href="/profile/file/edit/' . $id . '" class="text-info d-block">Modifier</a>'  . '<a href="/profile/file/delete/' . $id . '" class="text-danger d-block">Supprimer</a>';
        }

        $card =
            <<<Card
                <div class="card m-2 py-2 text-center" >
                <p class="overflow-hidden  d-flex flex-column justify-content-center" style="height: 100px;">$fileUploadedPreview</p>
                <div class="card-body">
                <p class="card-title"><strong>$title</strong></p>
                <p class="card-text">$description</p>
                <p class="card-text">Téléversé le $updatedAt par $by</p>
                <p class="card-text d-flex justify-content-around">
                    <a href="/assets/vichFiles/$fileName" target="_blank" class="d-block" >Visualiser</a>
                    $modifyString
                </p>
                </div>
            </div> 
            Card;
        return $card;
    }
}
