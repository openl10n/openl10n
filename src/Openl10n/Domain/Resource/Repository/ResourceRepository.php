<?php

namespace Openl10n\Domain\Resource\Repository;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Resource\Value\Pathname;

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
     *
     * @return Resource[]
     */
    public function findByProject(Project $project);

    /**
     *
     * @return Resource|null
     */
    public function findOneById($id);

    /**
     * @param Resource $resource
     */
    public function save(Resource $resource);

    /**
     * @param Resource $resource
     */
    public function remove(Resource $resource);
}
