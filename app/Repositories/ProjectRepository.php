<?php
/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 4/27/17
 * Time: 1:27 PM
 */

namespace app\Repositories;

use App\Project;
use Illuminate\Http\Request;

class ProjectRepository
{

    /**
     * @param int $id
     * @param string $projectName
     */
    public function createProject(Request $request)
    {
        Project::create($request->all());
    }


//    public function createDefaultProjectCover(int $id)
//    {
//        $project = new Project;
//        $project->name = '預設';
//        $project->ownerID = $id;
//        $project->thumPath = 'img/thum/1479129650.jpg';
//        $project->save();
//
//        $image = new ImageRepository;
//        $image->createDefaultPhoto($project->id);
//    }
//
//
//    public function createCollection(array $request)
//    {
//        $project = new Project;
//        $project->name = $request['name'];
//        $project->ownerID = (int)$request['id'];
//        $project->thumPath = 'img/thum/1479129650.jpg';
//        $project->save();
//    }
//
//    public function renameProject($request)
//    {
//        Project::where('id', $request['id'])
//            ->update(['name' => $request['name']]);
//    }
//
//    public function deleteProject(int $id)
//    {
//        Project::where('id', $id)->delete();
//    }
//
//    public function updateProjectCover(int $collectionsID, string $photoThumPath)
//    {
//        Project::where('id', $collectionsID)
//            ->update(['thumPath' => $photoThumPath]);
//    }
//
//    public function getUserLastProject(int $id)
//    {
//        $project = Project::where('ownerID', $id)
//            ->orderBy('id','desc')->first();
//        return $project;
//    }
//
//    public function getUserAllProjects(int $id)
//    {
//        $project = Project::where('ownerID', $id)
//            ->orderBy('id', 'asc')->get();
//        return $project;
//    }
//
//    public function getUserDefaultProjectID(int $id)
//    {
//        return Project::where('ownerID', $id)
//            ->where('name','預設')->value('id');
//    }
//
//    public function getUserProjectName(int $id)
//    {
//        return Project::where('id', $id)->value('name');
//    }


}