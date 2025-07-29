<?php

namespace App\Manager;

use App\Entity\ContactMessage;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final readonly class MailerManager
{
    public function __construct(
        private TranslatorInterface $translator,
        private MailerInterface $mailer,
        private ParameterBagInterface $parameterBag,
        private RouterInterface $router,
        private Environment $twig,
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendNewContactMessageNotificationToManager(ContactMessage $contactMessage): void
    {
        $email = new NotificationEmail()
            ->from(new Address($this->parameterBag->get('customer_delivery_address'), $this->parameterBag->get('project_title')))
            ->to($this->parameterBag->get('customer_delivery_address'))
            ->importance(NotificationEmail::IMPORTANCE_HIGH)
            ->subject($this->translator->trans('Message contact web form'))
            ->action(
                $this->translator->trans('Reply'),
                $this->router->generate(
                    'admin_app_contactmessage_reply',
                    [
                        'id' => $contactMessage->getId(),
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            )
            ->markdown(
                $this->twig->render(
                    '@App/mail/new_contact_message_form_notification_to_manager.md.twig',
                    [
                        'contact' => $contactMessage,
                    ]
                )
            )
        ;
        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendContactMessageReplyToPotentialCustomerNotification(ContactMessage $contactMessage): void
    {
        $email = new TemplatedEmail()
            ->from(new Address($this->parameterBag->get('customer_delivery_address'), $this->parameterBag->get('project_title')))
            ->to(new Address($contactMessage->getEmail(), $contactMessage->getName()))
            ->subject($this->translator->trans('Contact message answer').' '.$this->parameterBag->get('project_title'))
            ->htmlTemplate('@App/mail/contact_message_reply_notification_to_potential_customer.html.twig')
            ->context([
                'contact' => $contactMessage,
            ])
        ;
        $this->mailer->send($email);
    }
}
