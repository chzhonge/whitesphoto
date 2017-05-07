<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use App\Repositories\ImageRepository;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function validatorCheck(array $data, array $rule)
    {
        //Validator $validator
        $messages = [
            'unique' => 'The :attribute already registered.'
        ];
        $validator = Validator::make($data, $rule);
        return $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => $this->projectRepository->getUserAllProjects()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->projectRepository->createProject($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['data' => $this->projectRepository->getThisProjectAllImage($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->projectRepository->renameProject($request, $id);
        return response()->json(['data' => '命名成功']);
    }

    public function updateCover(Request $request)
    {
        $data = $request->all();

        $imageRepository = new ImageRepository;
        $photoThumPath = $imageRepository->getCoverThumPath($data['imageID']);


        $this->projectRepository->updateProjectCover($data['projectID'], $photoThumPath);
        return response()->json([
            'state' => 'updateProjectCover'
            ,'result' => true]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->projectRepository->deleteProject($id);
        return response()->json(['data'=>'刪除成功']);
    }
}
