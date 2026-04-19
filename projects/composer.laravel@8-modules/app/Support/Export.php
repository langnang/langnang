<?php

namespace App\Support;


class Export
{
    static function csv($filename, $data, $columns = []) {}
    static function json($filename, $data) {}
    static function md($filename, $data) {}
    static function sql($filename, $data) {}
    static function txt($filename, $data) {}
    static function xls($filename, $data, $columns = [])
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $activeSheet = $spreadsheet->getActiveSheet()->setTitle("Overview");

        foreach (array_keys($data) as $index => $key) {
            // $activeSheet->setCellValue("A" . ($index + 1), $key);
            $activeSheet->setCellValue("A" . ($index + 1), 'WorkSheet' . ($index + 1));
            $activeSheet->setCellValue("B" . ($index + 1), 'WorkSheet' . ($index + 1));
        }
        unset($index, $key);
        foreach ($data as $key => $listOrItem) {
            $sheet = $spreadsheet->createSheet();
            // $sheet->setTitle(substr(str_replace(["[", ":", "]"], "", $key), 0, 31));
            $item = $data['meta']->toArray();
            foreach (array_keys($item) as $index => $key) {
                $sheet->setCellValue(substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $index, 1) . '1', $key);
                $sheet->setCellValue(substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $index, 1) . '2', $item[$key] ?? '');
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'xls');
        return $writer->save('php://output');
    }
    static function xlsx($filename, $data, $columns = [])
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $activeSheet = $spreadsheet->getActiveSheet()->setTitle("Overview");

        foreach (array_keys($data) as $index => $key) {
            // $activeSheet->setCellValue("A" . ($index + 1), $key);
            $activeSheet->setCellValue("A" . ($index + 1), 'WorkSheet' . ($index + 1));
            $activeSheet->setCellValue("B" . ($index + 1), 'WorkSheet' . ($index + 1));
        }
        unset($index, $key);
        foreach ($data as $key => $listOrItem) {
            $sheet = $spreadsheet->createSheet();
            // $sheet->setTitle(substr(str_replace(["[", ":", "]"], "", $key), 0, 31));
            $item = $data['meta']->toArray();
            foreach ($columns as $index => $key) {
                $sheet->setCellValue(substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $index, 1) . '1', $key);
                $sheet->setCellValue(substr('ABCDEFGHIJKLMNOPQRSTUVWXYZ', $index, 1) . '2', $item[$key] ?? '');
            }
        }
        // $filename = '成绩表.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        return $writer->save('php://output');
    }
}
