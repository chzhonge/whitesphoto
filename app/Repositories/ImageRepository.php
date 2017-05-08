<?php
/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 4/27/17
 * Time: 2:19 PM
 */

namespace app\Repositories;

use App\Image as Photo;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Gregwar\Image\Image;
use Carbon\Carbon;

class ImageRepository
{
    private $rawType;
    private $imgFormat ='.jpg';
    private $thumWidth = 300;
    private $thumHeight = 200;
    private $rawBasePath = 'img/raw/';
    private $thumBasePath = 'img/thum/';

    public function createPhoto(Request $request)
    {
        $photo = new Photo;
        $photo->title = strval($request->photoName);
        $photo->author = strval($request->author);
        $photo->desc = strval($request->desc);
        $photo->projectID = $request->selected;

        $file = $request->file('image');

        $imgName = $this->getImgName(); // 還沒加副檔名
        $rawPath = $this->copyImg($file, $imgName);

        $photo->rawPath = $rawPath;
        $photo->thumPath = $this->makeThumImg($rawPath, $imgName);
        $photo->save();
        return $photo->id;
    }

    public function replaceType(string $fileType)
    {
        return str_replace("image/", "", $fileType);
    }

    public function createDefaultPhoto(int $projectID)
    {
        $photo = new Photo;
        $photo->title = '預設';
        $photo->author = '預設';
        $photo->desc = '預設';
        $photo->projectID = $projectID;
        $photo->thumPath = 'img/thum/1479129650.jpg';
        $photo->rawPath = 'img/raw/1479129650.jpg';
        $photo->save();
    }

    public function getThisProjectAllPhoto(int $projectID)
    {
        $photo = Photo::where('projectID', $projectID)->get();
        return $photo;
    }

    public function getThisPhotoInfo(int $photoID)
    {
        $photo = Photo::where('id', $photoID)->get();
        foreach ($photo as &$s) {
            $s['selected'] = Photo::where('id', $photoID)->value('projectID');
        }
        return $photo;
    }

    public function getPhotoIDList(int $projectID)
    {
        $photo = Photo::where('projectID', $projectID)
            ->orderBy('id', 'asc')
            ->pluck('id')->all();
        return $photo;
    }

    public function getCoverThumPath(int $photoID)
    {
        $photo = Photo::where('id', $photoID)->value('thumPath');
        return $photo;
    }


    public function deletePhoto(int $photoID)
    {
        Photo::where('id', $photoID)->delete();
    }

    public function updatePhoto(Request $request)
    {
        Photo::where('id', $request->id)
            ->update(['title' => $request->title,
                'author' => $request->author ,
                'desc' => $request->desc ,
                'projectID' => $request->selected
            ]);
    }

    public function getImgName()
    {
        return strval(Carbon::now()->timestamp);
    }


    public function copyImg($file, string $imgName)
    {
        $file->move($this->rawBasePath, $imgName);

        $type = '.'.$this->replaceType(mime_content_type($this->rawBasePath.$imgName));
        rename($this->rawBasePath.$imgName, $this->rawBasePath.$imgName.$type);
        $longRawPath = $this->rawBasePath.$imgName.$type;
        return $longRawPath;
    }

    public function makeThumImg(string $longRawPath, string $imgName)
    {
        Image::open($longRawPath)
            ->cropResize($this->thumWidth, $this->thumHeight)
            ->save($this->thumBasePath.$imgName.$this->imgFormat, 'jpg');
        $longThumPath = $this->thumBasePath.$imgName.$this->imgFormat;
        return $longThumPath;
    }
}
