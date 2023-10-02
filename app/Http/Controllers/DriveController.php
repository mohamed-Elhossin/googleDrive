<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriveController extends Controller
{

    public function listUserFile()
    {
        $userId = auth()->user()->id;
        $drives = Drive::where("userId", $userId)->get();
        return view("drives.yourFile", compact("drives"));
    }

    public function index()
    {
        $drives = DB::table('userdrives')->where("status", 'public')->get();
        return view("drives.index", compact("drives"));
    }

    public function create()
    {
        $category = DB::table("categories")->get();
        return view("drives.create", compact("category"));
    }

    public function changeStatus($id)
    {
        $drive = Drive::find($id);
        if ($drive->status == 'private') {
            $drive->status = 'public';
            $drive->save();

            return redirect()->back()->with("done", "This File Public Now");
        } else {
            $drive->status = 'private';
            $drive->save();

            return redirect()->back()->with("done", "This File Private Now");
        }
    }
    public function store(Request $request)
    {
        $size = 2*  1024;
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
        $drive->userId =  auth()->user()->id;
        $drive->save();

        return redirect()->back()->with("done", "Save File Done");
    }

    public function show($id)
    {
        $drive = Drive::find($id);
        return view("drives.show", compact("drive"));
    }

    public function allfiles()
    {
        $drives = Drive::all();
        return view("drives.allfiles", compact("drives"));
    }

    public function edit($id)
    {
        $drive = DB::table("drivewithcategory")->where("driveId", $id)->first();
        $category = DB::table("categories")->get();
        return view("drives.edit", compact('category', 'drive'));
    }



    public function update(Request $request, $id)
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
        $drive->userId =  auth()->user()->id;
        $drive->save();

        return redirect()->back()->with("done", "Save File Done");
    }


    public function destroy($id)
    {
        $drive = Drive::find($id);
        $filePath = public_path("upload/drives/" . $drive->file);
        unlink($filePath);
        $drive->delete();
        return redirect()->back()->with("done", "Remove File Done");
    }


    public function download($id)
    {
        $allData  = Drive::where("id", $id)->firstOrFail();
        $driveName = $allData->file;
        $filePath = public_path("upload/drives/" . $driveName);
        // dd($filePath);
        return response()->download($filePath);
    }
}
