<?php

declare(strict_types=1);

namespace app\custom\services\export;

use app\custom\services\export\exceptions\IncompatibleFormatException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use yii\base\Model;

class ExportExcelService
{
    private $attributes;

    public function export(array $models): void
    {
        if ($models[0] instanceof Model === false) {
            throw new IncompatibleFormatException();
        }

        $attributes = $this->getAttributes($models[0]);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=export_' . date('d.m.YH:i:s') . '.xlsx');
        header('Cache-Control: max-age=0');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($models as $index => $model) {
            // echo $model->username."<br>";
            for ($i=0; $i<\count($attributes); ++$i) {
                $attribute = $attributes[$i];
                $cellId = $this->getNameFromNumber($i) . ($index + 1);
                $sheet->setCellValue($cellId, $model->{$attribute});
            }
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setOffice2003Compatibility(true);
        ob_end_clean();
        $writer->save('php://output');
        exit;
    }

    private function getNameFromNumber($num)
    {
        $numeric = $num % 26;
        $letter = \chr(65 + $numeric);
        $num2 = (int)($num / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2 - 1) . $letter;
        }
        return $letter;
    }

    private function getAttributes(Model $model)
    {
        if ($model->hasMethod('getExportAttributes')) {
            return $model->getExportAttributes();
        }

        return $model->attributes();
    }
}
