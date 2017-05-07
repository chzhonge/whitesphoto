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
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
