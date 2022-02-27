<?php

namespace App\Twig;

use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PreviewExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter('preview', [$this, 'showPreview']),
        ];
    }

    public function showPreview($vichFile )
    {
        $absoluteUrl = "assets/vichFiles/$vichFile";
        try{
                $mimeContent = mime_content_type($absoluteUrl) ;

            if(str_contains($mimeContent, "image")){

                return "<img src='/$absoluteUrl' alt='$vichFile'>";
            }

            if(str_contains($mimeContent, "video")){
                return <<<VIDEO
                <video controls width="250" autoplay>
                
                <source src="/$absoluteUrl"
                type= "$mimeContent">
                
                
                
                Sorry, your browser doesn't support embedded videos.
                </video>
                
                VIDEO;
            }

            if(str_contains($mimeContent, "application/pdf")){

                return '<i class="fas fa-file-pdf"></i>';
            }

            if(str_contains($mimeContent, "word") || str_contains($mimeContent, "text")){

                return '<i class="far fa-file-word"></i>';
            }
            
            if(str_contains($mimeContent, "powerpoint") || str_contains($mimeContent, "powerpoint")){

                return '<i class="far fa-file-powerpoint"></i>';
            }
            if(str_contains($mimeContent, "excel") || str_contains($mimeContent, "sheet")){

                return '<i class="far fa-file-excel"></i>';
            }
            
            return '<i class="far fa-file-archive"></i>';
        } catch(Exception $e){
            return '<i class="far fa-question-circle"></i>';
        }
    }
}
