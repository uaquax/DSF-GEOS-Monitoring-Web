<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $files = Storage::disk('ftp')->allFiles();
        $fileNames = [];

        foreach ($files as $file) {
            $fileName = pathinfo($file, PATHINFO_BASENAME);
            $fileNames[] = $fileName;
        }

        return response()->json([
            "data" => $fileNames
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $newFile = $request->input("file");
        $newContent = $request->input('content');

        if ($newContent === null) {
            return response()->json([
                "error" => "Content cannot be null"
            ], 400);
        }
        if ($newFile === null) {
            return response()->json([
                "error" => "File cannot be null"
            ], 400);
        }

        Storage::disk('ftp')->put($newFile, $newContent);

        return response()->json([
            "message" => "File $newFile created successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $file)
    {
        //
        $contents = Storage::disk('ftp')->get($file);
        return response()->json([
            "data" => $contents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $file)
    {
        //
        $newContent = $request->input('content');

        if ($newContent === null) {
            return response()->json([
                "error" => "Content cannot be null"
            ], 400);
        }
        Storage::disk('ftp')->put($file, $newContent);

        return response()->json([
            "message" => "File $file updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $file)
    {
        //
        Storage::disk('ftp')->delete($file);
        return response()->json([
            "message" => "File $file deleted successfully"
        ]);
    }
}
