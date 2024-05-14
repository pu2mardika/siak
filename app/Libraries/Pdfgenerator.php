<?php
namespace App\Libraries;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;
use Config\MyApp;
use CodeIgniter\Files\File;

use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\{QRCode, QROptions};

class Pdfgenerator {
    public function generate($html, $filename='', $paper = 'A4', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('enable_remote', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
            exit();
        } else {            
			$fname 	 	 = $filename.'.pdf';
			$dirf 		 = setting()->get('MyApp.pdftmpDir');
			$path 		 = setting()->get('MyApp.pdfPath_Dir');
			$companyName = setting()->get('MyApp.companyName');
			$footer 	 = setting()->get('MyApp.appName')." ".setting()->get('MyApp.appVerison');

			$canvas = $dompdf->get_canvas();
			$fontmatrik = new FontMetrics($canvas, $options);
			$font = $fontmatrik->get_font("helvetica", "10");
			$txtHeight = $fontmatrik->get_font_height($font, 8);  
			$w = $canvas->get_width();
			$h = $canvas->get_height();
			$y = $h - 2 * $txtHeight - 30;
			
			$color = array(0, 0, 0);
			$text = $footer." | Generated on: ".date("d-m-Y H:i");
			$canvas->line(16, $y, $w - 16, $y, $color, 1);
			      
			$canvas->page_text(65, $y+3, $companyName, $font, 12, array(0,0,0));            
			$canvas->page_text(65, $y+15, $text, $font, 9, array(0,0,0));  

			$hsl= $dompdf->output();
			file_put_contents($path.$fname, $hsl);
			return base_url($dirf.$fname);
        }
    }
	
	public function create_pdf($html, $filename, $paper="A4", $orientation="potrait")
	{
		$myconfig = new MyApp;
		$dirf 	 = $myconfig ->pdftmpDir;
		$path 	 = $myconfig ->pdfPath_Dir;
		$fname 	 = $filename.'.pdf';
		
		$qr_url = $myconfig ->qrDirectory;		
		$companyName = setting()->get('MyApp.companyName');
		$logo 		 = setting()->get('MyApp.logo');
		$img_url 	 = setting()->get('MyApp.imagesURL');
		
		$options = new Options();
		$options->setIsPhpEnabled(true);
		$options->setIsRemoteEnabled(true);
		$options->set('enable_remote', TRUE);
		//$options->setDebugCss(true);
		$dompdf = new Dompdf($options);
		//$dompdf = new Dompdf(array('enable_remote' => true));
		$dompdf->set_option('defaultFont', 'Courier');
		
		//(Optional) Setup the paper size and orientation
		$dompdf->setPaper($paper, $orientation);
		
		$dompdf->loadHtml($html);
		
		// Render the HTML as PDF
		$dompdf->render();
		
		//MENAMBAHKAN Footer
		//$Font = new FontMetrics();
		$canvas = $dompdf->get_canvas();
		$fontmatrik = new FontMetrics($canvas, $options);
		
		//menambahkan gambar qr
		$qrcode = $qr_url.'qrcode.png';
		//$qrcode = 'images/tm.png';
		
		                
		$font = $fontmatrik->get_font("helvetica", "10");
		$txtHeight = $fontmatrik->get_font_height($font, 8);  
		 // draw a line along the bottom
		 // get height and width of page
	    $w = $canvas->get_width();
	    $h = $canvas->get_height();
		$y = $h - 2 * $txtHeight - 30;
		$footer = $myconfig->appName ." ". $myconfig->appVerison;
		
		$color = array(0, 0, 0);
		$text = $footer." | Generated on: ".date("d-m-Y H:i");
		$canvas->line(16, $y, $w - 16, $y, $color, 1);
        $canvas->image($qrcode, 20, $y, 40, 40);
       // $canvas->page_text(65, 805, $myconfig->siteName, $font, 12, array(0,0,0));            
        $canvas->page_text(65, $y+3, $companyName, $font, 12, array(0,0,0));            
        $canvas->page_text(65, $y+15, $text, $font, 9, array(0,0,0));            
		//$canvas->page_text(260, 810, $footer, $font, 9, array(0,0,0));
		$canvas->page_text($w-100, $y+3, "Page {PAGE_NUM} - {PAGE_COUNT}", $font, 9, array(0,0,0));
				
		//Add an image to the pdf  as watermax
		// Specify watermark image 
		$imageURL = 'images/logofinal.png'; 
		$imgWidth = 250; 
		$imgHeight = 250; 
		 
		// Set image opacity 
		$canvas->set_opacity(.05); 
		 
		// Specify horizontal and vertical position 
		$x = (($w-$imgWidth)/2); 
		$y = (($h-$imgHeight)/2); 
		 
		// Add an image watermark
		$canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight); 
		
        $hsl= $dompdf->output();
		file_put_contents($path.$fname, $hsl);
		return base_url($dirf.$fname);
	    
	}
	
	public function createQR($data, $fname = "qrcode.png")
	{
		$path = setting()->get('MyApp.qrPath_dir');
		$qrurl = setting()->get('MyApp.qrDirectory');
		
		$qrcode  = new QRCode;
		// set options after QRCode invocation
		$options = new QROptions;
		// $outputType can be one of: GDIMAGE_BMP, GDIMAGE_GIF, GDIMAGE_JPG, GDIMAGE_PNG, GDIMAGE_WEBP
		//$options->outputType          = QROutputInterface::GDIMAGE_PNG;
		$options->quality             = 60;
		// the size of one qr module in pixels
		$options->scale               = 20;
		$options->bgColor             = [200, 150, 200];
		$options->imageTransparent    = true;
		// the color that will be set transparent
		// @see https://www.php.net/manual/en/function.imagecolortransparent
		$options->transparencyColor   = [200, 150, 200];
		$options->drawCircularModules = true;
		$options->drawLightModules    = true;
		$options->circleRadius        = 0.4;
		$options->keepAsSquare        = [
			QRMatrix::M_FINDER_DARK,
			QRMatrix::M_FINDER_DOT,
			QRMatrix::M_ALIGNMENT_DARK,
		];
		/*
		$options->moduleValues        = [
			QRMatrix::M_FINDER_DARK    => [0, 63, 255], // dark (true)
			QRMatrix::M_FINDER_DOT     => [0, 63, 255], // finder dot, dark (true)
			QRMatrix::M_FINDER         => [233, 233, 233], // light (false)
			QRMatrix::M_ALIGNMENT_DARK => [255, 0, 255],
			QRMatrix::M_ALIGNMENT      => [233, 233, 233],
			QRMatrix::M_DATA_DARK      => [0, 0, 0],
			QRMatrix::M_DATA           => [233, 233, 233],
		];
		*/
		if(! is_dir($path)){mkdir($path,0777,true);	}
		//$fname = "qrcode.png";
		//RENDER
		(new QRCode($options))->render($data, $path.$fname);
		return base_url().$qrurl.$fname;	
	}
}