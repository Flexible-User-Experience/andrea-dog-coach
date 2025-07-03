<?php

namespace App\Controller\Web;

use App\Entity\ContactMessage;
use App\Enum\LocaleEnum;
use App\Enum\RoutesEnum;
use App\Form\Type\ContactMessageFormType;
use App\Manager\MailerManager;
use App\Repository\ContactMessageRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route(
        path: '/',
        name: RoutesEnum::app_web_homepage_route,
    )]
    public function homepage(Request $request, ServiceRepository $sr, ContactMessageRepository $cmr, MailerManager $mm): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageFormType::class, $contactMessage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cmr->add($contactMessage, true);
            $mm->sendNewContactMessageFromNotificationToManager($contactMessage);
            $this->addFlash(
                'success',
                'frontend.flash.on_contact_message_submit_success'
            );

            return $this->redirectToRoute('app_web_homepage');
        }

        return $this->render(
            'web/homepage.html.twig',
            [
                'services' => $sr->getActiveAndShowInFrontendSortedByPosition(),
                'form' => $form,
            ],
        );
    }

    #[Route(
        path: [
            LocaleEnum::ca => RoutesEnum::app_web_services_path_ca,
            LocaleEnum::es => RoutesEnum::app_web_services_path_es,
            LocaleEnum::en => RoutesEnum::app_web_services_path_en,
            LocaleEnum::de => RoutesEnum::app_web_services_path_de,
        ],
        name: RoutesEnum::app_web_services_route,
    )]
    public function servicesList(ServiceRepository $sr): Response
    {
        return $this->render('web/services.html.twig', [
            'services' => $sr->getActiveAndShowInFrontendSortedByPosition(),
        ]);
    }

    #[Route(
        path: [
            LocaleEnum::ca => RoutesEnum::app_web_contact_us_path_ca,
            LocaleEnum::es => RoutesEnum::app_web_contact_us_path_es,
            LocaleEnum::en => RoutesEnum::app_web_contact_us_path_en,
            LocaleEnum::de => RoutesEnum::app_web_contact_us_path_de,
        ],
        name: RoutesEnum::app_web_contact_us_route,
    )]
    public function contactUs(Request $request, ContactMessageRepository $cmr, MailerManager $mm): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageFormType::class, $contactMessage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cmr->add($contactMessage, true);
            $mm->sendNewContactMessageFromNotificationToManager($contactMessage);
            $this->addFlash(
                'success',
                'frontend.flash.on_contact_message_submit_success'
            );

            return $this->redirectToRoute('app_web_homepage');
        }

        return $this->render('web/contact_us.html.twig', [
            'form' => $form,
        ]);
    }
}
