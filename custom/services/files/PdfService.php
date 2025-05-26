<?php

declare(strict_types=1);

namespace app\custom\services\files;

use Dompdf\Dompdf;
use Yii;

class PdfService
{
    public function createPdf($data, $template, $path, $filename)
    {
        ini_set('memory_limit', '-1');

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // '@app/modules/catalog/views/common/products_pdf.php'
        $html = Yii::$app->view->renderFile($template, [
            'data' => $data,
        ]);

        $dompdf->loadHtml($html, 'UTF-8');

        // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper('A4', 'landscape');
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        // $dompdf->stream('sheet');

        // ex: '/files/favorites'
        $fullpath = Yii::getAlias('@webroot') . '/' . $path;
        if (!file_exists($fullpath)) {
            mkdir($fullpath, 0755, true);
        }

        $pdfPath = $fullpath . '/' . $filename;
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        $pdf = $dompdf->output();
        file_put_contents($pdfPath, $pdf);

        return str_replace(Yii::getAlias('@webroot'), '', $pdfPath);
    }
}
