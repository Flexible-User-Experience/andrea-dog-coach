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
        options: ['sitemap' => true]
    )]
    public function homepage(Request $request, ServiceRepository $sr, ContactMessageRepository $cmr, MailerManager $mm): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageFormType::class, $contactMessage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cmr->add(entity: $contactMessage, flush: true);
            $mm->sendNewContactMessageNotificationToManager($contactMessage);
            $this->addFlash(
                'info',
                'Your Message Has Been Sent Successfully'
            );

            return $this->redirectToRoute(RoutesEnum::app_web_homepage_route, [], Response::HTTP_SEE_OTHER);
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
        options: ['sitemap' => true]
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
        options: ['sitemap' => true]
    )]
    public function contactUs(Request $request, ContactMessageRepository $cmr, MailerManager $mm): Response
    {
        $this->addFlash(
            'info',
            'Your Message Has Been Sent Successfully'
        );
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageFormType::class, $contactMessage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cmr->add(entity: $contactMessage, flush: true);
            $mm->sendNewContactMessageNotificationToManager($contactMessage);
            $this->addFlash(
                'info',
                'Your Message Has Been Sent Successfully'
            );

            return $this->redirectToRoute(RoutesEnum::app_web_contact_us_route, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('web/contact_us.html.twig', [
            'form' => $form,
        ]);
    }
}
