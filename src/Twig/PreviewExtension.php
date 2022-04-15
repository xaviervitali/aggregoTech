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
            new TwigFilter('icon', [$this, 'icon']),
        ];
    }

    public function showPreview($vichFile)
    {
        $absoluteUrl = "assets/vichFiles/$vichFile";
        try {
            $mimeContent = mime_content_type($absoluteUrl);

            if (str_contains($mimeContent, "image")) {

                return "<img src='/$absoluteUrl' alt='$vichFile'>";
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

                return '<i class="fas fa-file-pdf" style="color:red;"></i>';
            }

            if (str_contains($mimeContent, "word") || str_contains($mimeContent, "text")) {

                return '<i class="far fa-file-word"  style="color:blue;"></i>';
            }

            if (str_contains($mimeContent, "powerpoint") || str_contains($mimeContent, "powerpoint")) {

                return '<i class="far fa-file-powerpoint"  style="color:orange;"></i>';
            }
            if (str_contains($mimeContent, "excel") || str_contains($mimeContent, "sheet")) {

                return '<i class="far fa-file-excel"  style="color:green;"></i>';
            }

            return '<i class="far fa-file-archive"  style="color:yellow;"></i>';
        } catch (Exception $e) {
            return '<i class="far fa-question-circle"></i>';
        }
    }

    public function icon($text)
    {
        $icons = [
            'Présentiel' => '<i class="fa-solid fa-handshake fa-2xl"></i>',
            'Appel Téléphonique' => '<i class="fa-solid fa-phone fa-2xl"></i>',
            'Visio' => '                        <i class="fa-solid fa-headset fa-2xl"></i>
',
            'Mail' => '<i class="fa-solid fa-envelope fa-2xl"></i>',
            'Courrier Postal' => '<i class="fa-solid fa-mailbox "></i>',

        ];

        return $icons[$text];
    }
}
