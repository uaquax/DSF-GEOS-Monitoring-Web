<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request The HTTP request object.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $files = Storage::disk('ftp')->allFiles();
        $limit = $request->query('limit', count($files) - 1);
        $fileNames = [];

        foreach ($files as $index => $file) {
            if ($index >= $limit) {
                break;
            }

            $fileName = pathinfo($file, PATHINFO_BASENAME);
            $fileNames[] = $fileName;
        }

        return view('files.index', ["files" => $fileNames]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $files = $request->input("selectedFiles");
        $dataArray = [];
        $currentSensor = 0;
        $maxSensor = 6;

        foreach ($files as $file) {
            // Read the file content from FTP disk
            $content = Storage::disk('ftp')->get($file);

            $currentDate = null;

            // Split the content by lines
            $lines = explode("\n", trim($content));

            foreach ($lines as $line) {
                if (count(explode("\t", $line)) < 4) {
                    // Store the current date
                    $dateSubstring = substr($line, 0, 12);
                    $currentDate = $this->parseDate($dateSubstring);
                    if ($currentDate === null) {
                        continue; // Skip invalid dates
                    }
                    if ($currentSensor >= $maxSensor) {
                        $currentSensor = 0;
                    }
                    $dataArray[$currentSensor][$currentDate] = [];
                    $dataArray[$currentSensor][$currentDate]["date"] = $currentDate;
                } else {
                    $currentSensor++;
                    // Split the line by tab
                    $elements = explode("\t", $line);
                    // Trim and convert each element to int
                    $data = array_map('intval', array_map('trim', $elements));
                    // Append the data to the corresponding data array
                    $dataArray[$currentSensor][$currentDate]["data"] = $data;
                }
            }
        }

        array_shift($dataArray);
        // dump($dataArray);
        return view("files.show", ['dataArray' => $dataArray]);
    }

    private function parseDate($dateSubstring)
    {
        try {
            $date = Carbon::createFromFormat('ymdHis', $dateSubstring)->format('Y-m-d H:i:s');
            return $date;
        } catch (\Exception $e) {
            return null;
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // $dataArray = [];

        // foreach ($files as $file) {
        //     $content = Storage::disk('ftp')->get($file);

        //     $lines = explode("\n", $content);
        //     $currentData = [];

        //     foreach ($lines as $line) {
        //         $line = trim($line);

        //         if (empty($line)) {
        //             continue;
        //         }

        //         if (is_numeric($line)) {
        //             if (!empty($currentData)) {
        //                 $dataArray[] = $currentData;
        //                 $currentData = [];
        //             }

        //             $currentData[] = 'Date';
        //             $currentData[] = $line;
        //         } else {
        //             $currentData[] = explode("\t", $line);
        //         }
        //     }

        //     if (!empty($currentData)) {
        //         $dataArray[] = $currentData;
        //     }
        // }

        // return view("files.show", ['dataArray' => $dataArray]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
