<?php
/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 4/27/17
 * Time: 1:27 PM
 */

namespace app\Repositories;

use App\Project;

class ProjectRepository
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function createDefaultCover()
    {

    }
}