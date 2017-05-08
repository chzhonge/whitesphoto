<?php
namespace app\Repositories;

use App\Project;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


//    public function createDefaultProjectCover()
//    {
//        $project = new Project;
//        $project->name = '預設';
//        $project->ownerID = $this->userID;
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
//        $project->ownerID = $this->userID;
//        $project->thumPath = 'img/thum/1479129650.jpg';
//        $project->save();
//    }
//
    public function renameProject($request, $id)
    {
        Project::where('id', $id)
            ->where('ownerID', Auth::id())
            ->update(['name' => $request['name']]);
    }
//
    public function deleteProject(int $id)
    {
        Project::where('id', $id)->where('ownerID', Auth::id())->delete();
    }

    public function getThisProjectAllImage(int $id)
    {
        $images = Image::where('projectID', $id)->get();
        return $images;
    }

    public function updateProjectCover(int $projectID, string $photoThumPath)
    {
        Project::where('id', $projectID)
            ->update(['thumPath' => $photoThumPath]);
    }
//
//    public function getUserLastProject()
//    {
//        $project = Project::where('ownerID', $this->userID)
//            ->orderBy('id','desc')->first();
//        return $project;
//    }

    public function getUserAllProjects()
    {
        $project = Project::where('ownerID', Auth::id())
            ->orderBy('id', 'asc')->get();
        return $project;
    }
//
//    public function getUserDefaultProjectID()
//    {
//        return Project::where('ownerID', $this->userID)
//            ->where('name','預設')->value('id');
//    }
//
//    public function getUserProjectName(int $id)
//    {
//        return Project::where('id', $id)->value('name');
//    }
}
