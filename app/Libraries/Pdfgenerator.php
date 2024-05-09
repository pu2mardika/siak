<?php
namespace App\Libraries;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;
use Config\MyApp;
use CodeIgniter\Files\File;

class Pdfgenerator {
    public function generate($html, $filename='', $paper = 'A4', $orientation = '', $stream=TRUE)
    {   
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
       // $dompdf = new Dompdf($options);
		$dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
            exit();
        } else {
            $dompdf->output();
            $domPdf = $pdf->getDomPDF();
  
	        $canvas = $domPdf->get_canvas();
	        $canvas->page_text(10, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, [0, 0, 0]);
        	return $pdf->download($filename.'.pdf');
        }
    }
	
	public function create_pdf($html, $filename, $paper="A4", $orientation="potrait")
	{
		$myconfig = new MyApp;
		$dirf 	 = $myconfig ->pdftmpDir;
		$path 	 = $myconfig ->pdfPath_Dir;
		$fname 	 = $filename.'.pdf';
		
		$img_url = $myconfig ->imagesURL;
		$logo 	 = $myconfig ->logo;
		
		$qr_url = $myconfig ->qrDirectory;
		
		$options = new Options();
		$options->setIsPhpEnabled(true);
		$options->setIsRemoteEnabled(true);
		//$options->setDebugCss(true);
		//$dompdf = new Dompdf($options);
		$dompdf = new Dompdf(array('enable_remote' => true));
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
        $canvas->page_text(65, $y+3, $myconfig->companyName, $font, 12, array(0,0,0));            
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
	
	
}