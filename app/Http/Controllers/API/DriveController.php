<?php

namespace App\Http\Controllers\API;

use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DriveController extends Controller
{

    public function listUserFile($id)
    {
        // Token ? User ID
        $userId = $id;
        $drives = Drive::where("userId", $userId)->get();

        if ($drives->isEmpty()) {
            $response = [
                "message" => "No Recordes Found",
                "satuts" => 404,
            ];
        } else {
            $response = [
                "message" => "List Drives Successfully",
                "satuts" => 200,
                "allData" => $drives
            ];
        }
        return response($response, 200);
    }

    public function index()
    {
        $drives = DB::table('userdrives')->where("status", 'public')->get();
        if ($drives->isEmpty()) {
            $response = [
                "message" => "No Recordes Found",
                "satuts" => 404,
            ];
        } else {
            $response = [
                "message" => "List Products Successfully",
                "satuts" => 200,
                "allData" => $drives
            ];

        }
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $drive = Drive::find($id);
        if ($drive->status == 'private') {
            $drive->status = 'public';
            $drive->save();

            return [
                "message" => "File Public Now",
                "status" => $drive->status
            ];
        } else {
            $drive->status = 'private';
            $drive->save();
            return [
                "message" => "This File Private Now",
                "status" => $drive->status
            ];
        }
    }


    public function store(Request $request)
    {
        $size = 2 *  1024;
        $request->validate([
            'title' => "required|string|min:3",
            "description" => "required|string",
            "category" => "required",
            "file" => "required|file|max:$size|mimes:png,jpg,pdf"
        ]);

        $drive = new Drive();
        $drive->title = $request->title;
        $drive->description = $request->description;
        // ===  File Data ==  ===  =
        $drive_data = $request->file("file");
        $driveName = time() . $drive_data->getClientOriginalName();
        $extensionData =  $drive_data->getClientOriginalExtension();
        $location = public_path('./upload/drives');
        $drive_data->move($location, $driveName);
        // ==================
        $drive->file = $driveName;
        $drive->categoryId = $request->category;
        $drive->extension = $extensionData;
        $drive->userId = $request->userId;
        $drive->save();

        $response = [
            "message" => "Create drive Data",
            "Data" => $drive,
            "Status" => 201
        ];
        return response($response, 201);
    }

    public function show($id)
    {
        $drive = Drive::find($id);
        if ($drive == null) {
            $response = [
                "message" => "No Recordes Found",
                "satuts" => 404,
            ];
        } else {
            $response = [
                "message" => "Send Products Successfully",
                "satuts" => 200,
                "allData" => $drive
            ];
        }

        return response($response, 200);
    }

    public function allfiles()
    {
        $drives = Drive::all();
        $response = [
            "message" => "List Products Successfully",
            "satuts" => 200,
            "allData" => $drives
        ];

        return response($response, 200);
    }


    public function update(Request $request, $id )
    {
        $drive = Drive::find($id);
        $drive->title = $request->title;
        $drive->description = $request->description;
        // ===  File Data ==  ===  =
        $drive_data = $request->file("file");
        $OldfilePath = public_path("upload/drives/" . $drive->file);
        if ($drive_data == null) {
            $driveName = $drive->file;
            $extensionData = $drive->extension;
        } else {
            $driveName = time() . $drive_data->getClientOriginalName();
            $extensionData =  $drive_data->getClientOriginalExtension();
            $location = public_path('./upload/drives');
            $drive_data->move($location, $driveName);
            unlink($OldfilePath);
        }


        // ==================
        $drive->file = $driveName;
        $drive->categoryId = $request->category;
        $drive->extension = $extensionData;
        $drive->userId =  $request->userId;
        $drive->save();

        $response = [
            "message" => "Update drive Data",
            "Data" => $drive,
            "Status" => 201
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $drive = Drive::find($id);
        $filePath = public_path("upload/drives/" . $drive->file);
        unlink($filePath);
        $drive->delete();
        $response = [
            "message" => "Update drive Data",
            "Data" => $drive,
            "Status" => 201
        ];
        return response($response, 201);
    }


    public function download($id)
    {
        $allData  = Drive::where("id", $id)->firstOrFail();
        $driveName = $allData->file;
        $filePath = public_path("upload/drives/" . $driveName);
        // dd($filePath);
        $response = [
            "message" => "Update drive Data",
            "Data" => $driveName,
            "Status" => 201
        ];
        return response($response, 201)->download($filePath);

    }
}
