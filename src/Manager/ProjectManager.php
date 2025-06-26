<?php

namespace App\Manager;

use App\Entity\Project;
use App\Repository\ProjectRepository;

final class ProjectManager
{
    private ProjectRepository $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getPreviousProjectOf(Project $project): ?Project
    {
        $index = 0;
        $previous = null;
        $projects = $this->projectRepository->getActiveAndShowInFrontendSortedByYearAndName();
        foreach ($projects as $index => $item) {
            if ($project->getId() === $item->getId()) {
                break;
            }
        }
        if ($index - 1 > 0) {
            $previous = $projects[$index - 1];
        }

        return $previous;
    }

    public function getFollowingProjectOf(Project $project): ?Project
    {
        $index = 0;
        $following = null;
        $projects = $this->projectRepository->getActiveAndShowInFrontendSortedByYearAndName();
        foreach ($projects as $index => $item) {
            if ($project->getId() === $item->getId()) {
                break;
            }
        }
        if ($index + 1 < count($projects)) {
            $following = $projects[$index + 1];
        }

        return $following;
    }
}
