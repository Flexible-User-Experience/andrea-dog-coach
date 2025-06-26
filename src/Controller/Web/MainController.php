<?php

namespace App\Controller\Web;

use App\Entity\ContactMessage;
use App\Entity\Project;
use App\Form\Type\ContactMessageFormType;
use App\Manager\MailerManager;
use App\Manager\ProjectManager;
use App\Repository\ContactMessageRepository;
use App\Repository\ProjectRepository;
use App\Repository\ServiceRepository;
use App\Security\Voter\FrontendVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MainController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'app_web_homepage',
    )]
    public function homepage(ServiceRepository $sr): Response
    {
        return $this->render('web/homepage.html.twig', [
            'services' => $sr->getActiveAndShowInFrontendSortedByPosition(),
        ]);
    }

    #[Route(
        path: [
            'ca' => '/projectes',
            'es' => '/proyectos',
            'en' => '/projects',
        ],
        name: 'app_web_projects_list',
    )]
    public function projectsList(ProjectRepository $pr): Response
    {
        return $this->render('web/projects.html.twig', [
            'years' => $pr->getAvailableYearsArraySortedByValue(),
            'projects' => $pr->getActiveAndShowInFrontendSortedByYearAndName(),
        ]);
    }

    #[Route(
        path: [
            'ca' => '/projectes/any/{year}',
            'es' => '/proyectos/año/{year}',
            'en' => '/projects/year/{year}',
        ],
        name: 'app_web_project_by_year_detail',
    )]
    public function projectByYearDetail(int $year, ProjectRepository $pr): Response
    {
        return $this->render('web/project_year_detail.html.twig', [
            'years' => $pr->getAvailableYearsArraySortedByValue(),
            'selected_year' => $year,
            'projects' => $pr->getProjectsByYearActiveAndShowInFrontendSortedByName($year),
        ]);
    }

    #[IsGranted(FrontendVoter::PUBLISHED_AND_ACTIVE, 'project')]
    #[Route(
        path: [
            'ca' => '/projecte/{slug}',
            'es' => '/proyecto/{slug}',
            'en' => '/project/{slug}',
        ],
        name: 'app_web_project_detail',
    )]
    public function projectDetail(ProjectManager $pm, Project $project): Response
    {
        return $this->render('web/project_detail.html.twig', [
            'previous_project' => $pm->getPreviousProjectOf($project),
            'project' => $project,
            'following_project' => $pm->getFollowingProjectOf($project),
        ]);
    }

    #[Route(
        path: [
            'ca' => '/contacte',
            'es' => '/contacto',
            'en' => '/contact',
        ],
        name: 'app_web_contact',
    )]
    public function contact(Request $request, ContactMessageRepository $cmr, MailerManager $mm): Response
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
            'web/contact.html.twig', [
                'form' => $form,
            ],
            new Response(null, $form->isSubmitted() && !$form->isValid() ? Response::HTTP_UNPROCESSABLE_ENTITY : Response::HTTP_OK)
        );
    }
}
