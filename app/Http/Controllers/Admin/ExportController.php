<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    static function downloadCsv($table,$selectedValue,$selectedTexts)
    {
        $selectedColumn = array();
        $header = array();
        if(isset($selectedValue) && isset($selectedTexts) )
        {
            $selectedColumn = implode(', ', $selectedValue);
            $header = $selectedTexts;
        }
        $file_name = 'data_'.date('Ymd').'.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file_name");
         header("Content-Type: application/csv;");
        header('Access-Control-Allow-Origin: *');  // CORS header

        $queryData =$table
            ->select($selectedColumn)
            ->get()
            ->getResultArray();
        // file creation
        $file = fopen('php://output', 'w');

        fputcsv($file, $header);
        foreach ($queryData as $key => $value)
        {
            fputcsv($file, $value);
        }
        fclose($file);

        return $file;

    }

    public function FetchCsv($header,$queryData)

    {

        $file_name = 'data_'.date('Ymd').'.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file_name");
         header("Content-Type: application/csv;");
        header('Access-Control-Allow-Origin: *');  // CORS header

        $file = fopen('php://output', 'w');

        fputcsv($file, $header);
        foreach ($queryData as $key => $value)
        {
            $value = (array) $value;
            fputcsv($file, $value);
        }
        fclose($file);
        exit;

    }
}
