<?php


namespace App\Traits;

use Imagick;
use Illuminate\Support\Facades\Validator;


trait AddCevToDoc
{

    function pose($pdf, $base64_content, $x, $y)
    {
        // Get the PDF document's resource
        $resource = $pdf->getResource();

        // Create a new image object
        $image = new Imagick();

        // Decode the base64 content
        $image->readImageBlob(base64_decode($base64_content));

        // Get the image's width and height
        $width = $image->getImageWidth();
        $height = $image->getImageHeight();

        // Create a new page in the PDF document
        $pdf->newPage();

        // Set the position of the image
        $pdf->translate($x, $y);

        // Embed the image in the PDF document
        $pdf->drawImage($image, 0, 0, $width, $height);

        // Close the image object
        $image->destroy();
    }


}
