<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Project\Model\Project as ProjectModel;

class Project
{
    /**
     * Identifier of the project.
     *
     * @Serializer\Type("string")
     */
    public $slug;

    /**
     * Displayed name of the project.
     *
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * The reference locale used to identify resources.
     *
     * @Serializer\Type("string")
     */
    public $defaultLocale;

    public function __construct(ProjectModel $project)
    {
        $this->slug = (string) $project->getSlug();
        $this->name = (string) $project->getName();
        $this->defaultLocale = (string) $project->getDefaultLocale();
    }
}
