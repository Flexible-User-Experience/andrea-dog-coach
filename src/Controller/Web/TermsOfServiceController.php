<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TermsOfServiceController extends AbstractController
{
    #[Route(
        path: [
            'ca' => '/politica-de-privacitat',
            'es' => '/politica-de-privacidad',
            'en' => '/privacy-policy',
            'de' => '/privacy-policy',
        ],
        name: 'app_web_privacy_policy',
    )]
    public function projectsList(): Response
    {
        return $this->render('web/privacy_policy.html.twig');
    }
}
