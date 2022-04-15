<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtToutLeMondeSEnFoutController extends AbstractController
{
    #[Route('/admin/exutoire', name: 'exutoire')]
    public function index(): Response
    {
        $phrases = [
            "Va te curer les dents à la perceuse", "Rebranche tes neurones",
            "Retourne jouer avec le mixeur", "Tes parents ont peut-être confondu le lait avec la lessive",
            "Si tu te concentres, tu arriveras peut-être à penser", "Va reprendre un bol de gravier",
            "Regarde à'autonomie' dans le dictionnaire", "Va enfiler ton leggin au bord d'une falaise",
            "Appelle le service après-vente de ta perspicacité", "Bande-toi les yeux et cours très vite dans une forêt", "Sache que ton espèce est peut-être en voie de disparition",
            "Va te faire un bain de bouche avec une poire à lavement",
            "Je crois que tu n'as pas téléchargé la mise à jour de ton cerveau",
            "Peut-être qu'on t'a vacciné trop petit contre la perspicacité",
            "Va faire une sieste dans la betonneuse",
            "Prends un forceps pour ouvrir ton esprit",
            "Va faire un calin à l'autoroute",
            "Je crois que ton cerveau est myope",
            "Va te sécher les cheveux au micro-onde",
            "Va cueilllir des fleurs dans un champs de mines",
            "Remonte le temps et empêche tes parents de se rencontrer",
            "Va mettre la dinde au four, mais rentre en premier",
            "Va te tricoter une echarpe avec du fil barbelé",
            "Peut-être que ton cerveau existe dans la taille au-dessus",
            "Enlève le bouton pause de ton cerveau",
            "Prends deux minutes pour compter jusqu'à l'infini",
            "Va t'enterrer pour vois si tu pousses",
            "Va te faire de l'acupuncture avec un tisonnier",
            "Va te mettre en mode avion",
            "Va te masser les tempes à la ponceuse éléctrique",
            "Va faire un pique-nique sur le passage à niveau",
            "Allume un cierge et range-le dans ta poche",
            "Va prendre des vacances à Fukushima",
            "Peut-être que tes neurones souffrent d'un décalage horaire",
            "Va mettre tes idées dans la poubelle jaune ... s'il te plait",
            "Va te maquiller avec un fer un souder",
            "Inspire profondément ... et ne t'arrête surtout pas",
            "Va macher un chewing-gum à la super glue",
            "Va passer l'aspirateur sur la plage",
            "Va te faire une tisane au ciment",
            "Va remettre tes idées dans le formol",
            "Va jouer au cymbales avec un défibrilateur",
            "Va rafraichir tes idées dans la glace carbonique",
            "Va te faire coiffer au bistouri",
            "Enlève le tampon qui absorbe ton liquide cérébral",
            "Déguise toi en bûche et fais un feu",
            "Tu vois où il est, ton cerveau ?",
            "Va jouer au jokari avec un boule de pétanque",
            "Je crois que ton empathie vient de se faire la malle avec ton amour propre",
            "Va te faire une manucure à Guantánamo",
            "Va frapper ta t^te contre une brique jusqu'à ce qu'il y ait des pièces",
            "Va faire un cuni à la tondeuse à gazon",
            "Je vais lubrifier mes idées, pour qu'elles rentrent plus facilement dans ta tête",
            "Je crois que ton ignorance vient de sortir du placard",
            "Va te faire un sandwich au Xanax",
            "Va rouler un pelle à un pot d'échappement",
            "Va lire ton avenir dans un barre d'uranium",
            "On va respecter les limites de ton cerveau en employant des mots simples",
            "Va faire du parapente avec un soutien-gorge",
            "Mets une cape rouge et va traire un taureau",
            "Peut-être que ton cerveau est en garde alternée",
            "Va faire du trampoline sous un abribus",
            "Va faire une bataille d'oreillers avec des parpaings",
            "Je crois que ta dignité me demande le droit d'asile",
            "Je pense que ton corps est en carence de cerveau",
            "Va méditer dans une fosse septique",
            "Va te rafraîchir en sirotant le pédiluve",
            "Lime tes ongles sur la trancheuse à jeambon",
            "Je crois que tes neurones sont en train de quitter le navire",
            "Malaxe ta prostate avec des orties",
            "Je crois que le manque d'iode atrophie ton QI",
            "Rince tes idées à la javel",
            "Peut-être que ton cerveau est resté en jachère ?",
            "Brosse ets dents jusqu'à ce qu'il n'y en ait plus",
            "Extériorise ta rage sur radiateur avec ta tête",
            "Bois un verre d'eau en faisant le poirier",
            "Injecte du botox dans ton oeil pour rafraîchir ton point de vue",
            "Peut-être que ton cerveau est abstentionniste ?",
            "Va te faire le point sur ta vie les deux pieds dans le ciment",
            "Tais-toi plus fort",
            "Va faire du déambulateur au fond de la piscine",
            "Va faire du pole dance sur un cactus",
            "Va faire une séance d'uv dans un congélateur",
            "Va faire un mononwalk sur une râpe à fromage",
            "Allonge toi dans l'herce et mâche du fumier",
            "Je crois que ta pertinence est portée disparue",
            "Tu veux respirer dans un sac en papier pour gérer ta panique ?",
            "N'achète plus tes neurones sur internet",
            "Il te reste encore un peu de préjuger entre les dents",
            "Peut-être que ton cerveau fait de l'apnée ?",
            "Tu sens l'odeur de moisi ? C'est ta vision du monde qui vient de dépasser sa date péremption",
            "Va refaire le crépi avec ton front",
            "Va jouer à colin-maillard sur les rails du métro",
            "Peut-être que ton cerveau joue à cache-cache",

        ];
        return $this->render('et_tout_le_monde_s_en_fout/index.html.twig', [
            "phrases" => $phrases
        ]);
    }
}
