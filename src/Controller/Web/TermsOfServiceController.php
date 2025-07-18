<?php

namespace App\Controller\Web;

use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TermsOfServiceController extends AbstractController
{
    #[Route(
        path: [
            LocaleEnum::ca => RoutesEnum::app_web_privacy_policy_path_ca,
            LocaleEnum::es => RoutesEnum::app_web_privacy_policy_path_es,
            LocaleEnum::en => RoutesEnum::app_web_privacy_policy_path_en,
            LocaleEnum::de => RoutesEnum::app_web_privacy_policy_path_de,
        ],
        name: RoutesEnum::app_web_privacy_policy_route,
    )]
    public function projectsList(): Response
    {
        return $this->render('web/privacy_policy.html.twig');
    }
}
