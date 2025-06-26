<?php

namespace App\Controller\Web;

use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TermsOfServiceController extends AbstractController
{
    #[Route(
        path: [
            'ca' => RoutesEnum::app_web_privacy_policy_ca,
            'es' => RoutesEnum::app_web_privacy_policy_es,
            'en' => RoutesEnum::app_web_privacy_policy_en,
            'de' => RoutesEnum::app_web_privacy_policy_de,
        ],
        name: 'app_web_privacy_policy',
    )]
    public function projectsList(): Response
    {
        return $this->render('web/privacy_policy.html.twig');
    }
}
