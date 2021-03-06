<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonImgUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Lessonimg;
use Illuminate\Support\Facades\Log;

class LessonImgUploadController extends Controller
{
    /**
     * 画像アップロード
     */
    public function imgupload(LessonImgUploadRequest $request)
    {
        Log::debug('<<<<<<<< imgupload ajax>>>>>>>>>>>>>');

        $Lessonimg = new Lessonimg;
        $Lessonimg->path = $request->file;
        $path = $request->file->store('public/lesson_images');
        $Lessonimg->path = str_replace('public/', '', $path);

        Log::debug('<<<<<<<< $Lessonimg 内容 >>>>>>>>>>>>>');
        $Lessonimg->save();

        return response()->json($Lessonimg->path);
    }
}
