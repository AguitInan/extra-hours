<?php

include 'export_funique.php';

// On unsérialise $excel
$excel = unserialize($_POST['excel']);
$workbook = new export_funique();
$sheet = $workbook->getActiveSheet();

$sheet->duplicateStyleArray(
		array(
			'font'    => array(
				'bold'      => true,
				'size'		=> 11,
				'color'		=> array(
					'rgb'		=> '006633'
					)
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'	=> PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		),
		'A1:AD1'
);


$sheet->getRowDimension('1')->setRowHeight(15);
$sheet->setTitle('Export');


$longueur = count($excel);
$largeur = count($excel[1]);

for ($i=0;$i<$longueur;$i++)
{
	for ($j=0;$j<$largeur;$j++){
		
		$sheet->setCellValueByColumnAndRow($j, $i+1, $excel[$i][$j]);

	}
	
	// Conversion du format de la colonne Rubrique en type 0.00
	$workbook->getActiveSheet()->getStyle('D'.($i+1))->getNumberFormat()->setFormatCode('0.00');

}


$filename = "paye-".date("d-m-Y");
$workbook->affiche('Excel5',$filename);

?>