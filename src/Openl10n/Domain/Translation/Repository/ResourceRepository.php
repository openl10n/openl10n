<?php

namespace Openl10n\Domain\Translation\Repository;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Domain\Translation\Model\Resource;
use Openl10n\Domain\Translation\Value\Pathname;

interface ResourceRepository
{
    /**
     * @param Project  $project
     * @param Pathname $pathname
     *
     * @return Resource
     */
    public function createNew(Project $project, Pathname $pathname);

    /**
     * @param Project  $project
     * @param Pathname $pathname
     *
     * @return Resource[]
     */
    public function findByProject(Project $project);

    /**
     * @param Project $project
     * @param string  $hash
     *
     * @return Resource|null
     */
    public function findOneById(Project $project, $id);

    /**
     * @param Resource $resource
     */
    public function save(Resource $resource);

    /**
     * @param Resource $resource
     */
    public function remove(Resource $resource);
}
