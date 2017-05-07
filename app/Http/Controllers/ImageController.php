<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use Validator;

class ImageController extends Controller
{
    protected $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function index($id)
    {
        return response()->json([
            'state' => 'getCoverPreviewList'
            ,'data' => $this->imageRepository->getThisProjectAllPhoto($id)]);
    }

    public function getImgIDList($id)
    {
        return response()->json([
            'state' => 'getPhotoIDList'
            ,'result' => $this->imageRepository->getPhotoIDList($id)]);
    }


    public function getInfo($id)
    {
        return response()->json([
            'state' => 'getThisPhotoInfo'
            ,'result' => $this->imageRepository->getThisPhotoInfo($id)]);
    }

    public function store(Request $request)
    {
        $messages = [
            'unique' => 'The :attribute already registered.'
        ];

        $validator = Validator::make($request->all(), [
            'photoName' => 'required|max:255|string|',
            'author' => 'required|max:255|string|',
            'desc' => 'required|max:255|string|',
            'selected' =>'required|min:1|exists:project,id|integer|',
            'image' =>'required|image'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'state' => 'createProject'
                ,'result' => false
                ,'because' => $validator->messages()]);
        }

        $this->imageRepository->createPhoto($request);
        return response()->json([
            'state' => 'createPhoto'
            ,'result' => true]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        $this->imageRepository->updatePhoto($request);
        return response()->json([
            'state' => 'updatePhoto'
            ,'result' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->imageRepository->deletePhoto($id);
        return response()->json([
            'state' => 'destroyPhoto'
            ,'result' => true ]);
    }
}
