<?php

namespace App\Http\Controllers;

use stdClass;
use setasign\Fpdi\Fpdi;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Imagick;

class PDFController extends BaseController
{
    public function index(Request $request)
    {
        $filePath = public_path("sample.pdf");
        $outputFilePath = public_path("sample_output.pdf");
        $this->fillPDFFile($filePath, $outputFilePath);

        return response()->file($outputFilePath);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fillPDFFile($file, $outputFilePath)
    {
        $fpdi = new FPDI;

        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("helvetica", "", 15);
            $fpdi->SetTextColor(153, 0, 153);
            $left = 10;
            $top = 10;
            $text = "itsolutionstuff.com";
            $fpdi->Text($left, $top, $text);
            // $image = new Imagick();
            // $svg = file_get_contents(public_path("image.svg"));
            // $image->readImageBlob($svg);
            // $image->setImageFormat('png24');
            // $pngtmp = public_path("image.png");
            // $image->writeImage($pngtmp);
            // $image->clear();
            // $image->destroy();
            $fpdi->Image(public_path("logo.jpg"), 40, 90);
        }

        return $fpdi->Output($outputFilePath, 'F');
    }
}
