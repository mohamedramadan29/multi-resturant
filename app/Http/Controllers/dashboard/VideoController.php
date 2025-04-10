<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Setting;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function UploadVideo()
    {
        $settingVideo = Setting::whereNull('resturant_id')->first();
        return view('dashboard.Video.index',compact('settingVideo'));
    }

    public function uploadChunk(Request $request)
    {
        $file = $request->file('chunk');
        $chunkIndex = $request->input('chunkIndex');
        $fileIdentifier = $request->input('fileIdentifier');
        $totalChunks = $request->input('totalChunks');

        $uploadPath = storage_path("app/chunks/$fileIdentifier");
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file->move($uploadPath, "chunk_$chunkIndex");

        return response()->json(['status' => 'success', 'chunkIndex' => $chunkIndex]);
    }

    public function mergeChunks(Request $request)
    {
        $setting = Setting::whereNull('resturant_id')->first();
        $fileIdentifier = $request->input('fileIdentifier');
        $originalFileName = $request->input('originalFileName');
        $uploadPath = storage_path("app/chunks/$fileIdentifier");
        $finalPath = public_path("assets/uploads/videos");

        if (!file_exists($finalPath)) {
            mkdir($finalPath, 0777, true);
        }

        $finalFilePath = "$finalPath/$originalFileName";
        $finalFile = fopen($finalFilePath, 'wb');

        $totalChunks = $request->input('totalChunks');
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = fopen("$uploadPath/chunk_$i", 'rb');
            fwrite($finalFile, fread($chunkFile, filesize("$uploadPath/chunk_$i")));
            fclose($chunkFile);
        }

        fclose($finalFile);

        // حذف الأجزاء بعد الدمج
        array_map('unlink', glob("$uploadPath/*"));
        rmdir($uploadPath);

        // تحديث الفيديو في قاعدة البيانات للمنتج المحدد

        if ($setting) {
            $setting->video = "$originalFileName";
            $setting->save();
        }

        return response()->json(['status' => 'completed', 'video_path' => "assets/uploads/videos/$originalFileName"]);
    }
}
