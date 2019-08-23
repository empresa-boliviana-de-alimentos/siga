<?php

namespace siga\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
//use Dompdf\Dompdf;
use App;

class RerportController extends Controller
{
    public function prueba()
    {  	
    	$username = 'roddwy';
        $title = "Reporte";
        $date =Carbon::now();        
        $view = \View::make('layouts.print', compact('username','date','title'));
        $html_content = $view->render();
        $pdf = App::make('snappy.pdf.wrapper');
		$pdf->loadHTML($html_content);
		return $pdf->inline();
        
    }
}
