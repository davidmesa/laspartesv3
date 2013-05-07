<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja la página principal
 */
class ExcelPromociones extends Laspartes_Controller{
	
	var $ultimo_precio = 0;
	
	/**
	 * Constructor de la clase Inicio
	 */
	function __construct(){
		parent::__construct();
	}

	/**
	 * Muestra la página principal
	 */
	function index($dataP = array()){
		$this->load->model('excel_model');
		$establecimientos = $this->excel_model->dar_establecimientos();
		
		$data = array();
		$data['establecimientos'] = $establecimientos;
		$this->load->view('excel/formPromocion', $data);
	}
	
	function cargar(){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'xls|xlsx';

		$this->load->library('upload', $config);
		$this->load->library('phpexcel');

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('excel/form', $error);
		}
		else
		{
			$upload_data = (object) $this->upload->data();
			$data = array('upload_data' => $upload_data);
			$objPHPExcel = PHPExcel_IOFactory::load($upload_data->full_path);
			
			$id_establecimiento = $this->input->post('establecimiento');
			
			$processedSheets = array();
			
			$sheetIterator = $objPHPExcel->getWorksheetIterator();
			$sheet = 0;
			while($sheetIterator->valid()){
				$sheet = $sheetIterator->current();
				
				$products = array();
				$this->_processSheet($sheet, $products);
				$this->_processProducts($products, $id_establecimiento);
				$processedSheets[$sheet->getTitle()] = $products;
				$sheetIterator->next();
			}
			$data['sheets'] = $processedSheets;
			
//			$this->load->view('excel/successPromocion', $data);
		}
	}
	
	function _processProducts(&$products, $id_establecimiento){
		$this->load->model('excel_model');
		foreach($products as $product){ 
			foreach($product->items as $item){
                            $vehiculos = array();
                            $comas= strpos($item->marca, ',');
                            if($item->marca == 'Multimarcas' || $item->marca == 'Multimarca'){ 
                                $item->marca = ''; 
                                $vehiculos = $this->excel_model->dar_vehiculo_tipo_marca($item->tipoCarro);
                            }else if($comas){
                                $marcas= split(',', $item->marca);
                                foreach ($marcas as $marca):
                                   $vehiculosTemp = $this->excel_model->dar_vehiculo_tipo_marca($item->tipoCarro, $marca);
                                   $vehiculos = array_merge($vehiculos, $vehiculosTemp);
                                endforeach;
                            }else{
                                $vehiculos = $this->excel_model->dar_vehiculo_tipo_marca($item->tipoCarro, $item->marca); 
                            }
                            $precio = $item->precio; 
                            $titulo = $item->categoria.' por $ '.number_format($precio, 0, ',', '.').' a través de laspartes.com';
                            if($item->categoria == 'Cambio Aceite' || $item->categoria == 'Cambio Aceite '){
                                $item->categoria = 'Cambio de aceite';
                                $iva = $item->iva;
                                $base = $precio-$iva;
                            }elseif($item->categoria == 'Técnico-Mecanica'){
                                $iva = $item->iva;
                                $base = $precio-$iva;
                            }
                            else{
                                $iva = 1+$item->iva;
                                $base = $precio/$iva;
                                $iva = $precio-$base;
                            }
                            $condiciones = $item->condiciones;
                            $incluye = $item->incluye;
                            $vigencia = $item->vigencia;
                            $vigencia = str_replace('Oct', '10', $vigencia);
                            $vigencia = str_replace('Sep', '09', $vigencia);
                            $vigencia = str_replace('Ago', '08', $vigencia);
                            $vigencia = str_replace('Jul', '07', $vigencia);
                            $vigencia = str_replace('Jun', '06', $vigencia);
                            $vigencia = str_replace('May', '05', $vigencia);
                            $vigencia = str_replace('Abr', '04', $vigencia);
                            $vigencia = str_replace('Mar', '03', $vigencia);
                            $vigencia = str_replace('Feb', '02', $vigencia);
                            $vigencia = str_replace('Ene', '01', $vigencia);
                            $vigencia = str_replace('Dic', '12', $vigencia);
                            $vigencia = str_replace('Nov', '11', $vigencia);
                            list($mes, $dia, $ano) = split('-', $vigencia);
                            $vigencia = $ano.'-'.$mes.'-'.$dia;
                            $margenLP = $base*($item->margenLP);
                            $dcoOferta = ($item->dcoFeria)*100;
                            $plazo = $item->plazo;
                            List($numPlazo) = split(' ', $plazo, 1);
                            $plazo = $numPlazo;
                            $id_categoria = $this->excel_model->dar_id_servicios_categoria($item->categoria);
                            $id_oferta = $this->excel_model->agregar_promocion($titulo, $precio, $iva, $condiciones, $incluye,$vigencia, $margenLP, $dcoOferta, $plazo);
//                            
                            foreach ($vehiculos as $tem):
                                $this->excel_model->agregar_establecimiento_promocion($tem->id_vehiculo, $id_categoria, $id_oferta, $id_establecimiento);
                            endforeach;
                            
                            
                            echo 'Titulo: '.$titulo.'<br/>';
                            echo 'Vigencia: '.$vigencia.'<br/>';
                            echo 'Plazo: '.$plazo.'<br/>';
                            echo 'Precio: '.$precio.'<br/>';
                            echo 'Base: '.$base.'<br/>';
                            echo 'Iva: '.$iva.'<br/>';
                            echo 'MargenLP: '.$margenLP.' % = '.$item->margenLP.'<br/>';
                            echo 'DCO oferta: '.$dcoOferta.'<br/>';
                            echo 'Condiciones: '.$condiciones.'<br/>';
                            echo 'Incluye: '.$incluye.'<br/><br/><br/>';
			}
		}
	}
	
	function _processSheet(PHPExcel_Worksheet $sheet, &$products){
		$rows = array();
	
		$rowIterator = $sheet->getRowIterator();
		$i = -1;
		while($rowIterator->valid()){
			$row = $rowIterator->current();
			
			if($i >= 0){
				$rows[$i] = $this->_processRow($sheet, $row, $i, $products);
			}
			$rowIterator->next();
			$i++;
		}
	}
	
	function _processRow($sheet, $row, $index = 0, &$products = array()){
		$values = array();
	
		$i = 0;
		$cellIterator = $row->getCellIterator();
		
		$promo = NULL;
                $p = new stdClass();
                $p->items = array();
                $products[] = $p;
		while($cellIterator->valid()){
			$cell = $cellIterator->current();
                        
                        if($index >= 0){
				
				if(!$promo){
					$promo = new stdClass();
				}
				
				
				if($i%13 == 1){
					$promo->categoria = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
				}
                                if($i%13 == 2){
					$promo->incluye = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        
				}
				if($i%13 == 3){
					$promo->taller = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
				}
                                if($i%13 == 4){
					$promo->marca = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
				}
				if($i%13 == 5){
					$tipoCarro = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        if($tipoCarro == '1,2')
                                            $promo->tipoCarro = 3;
                                        else
                                            $promo->tipoCarro = $tipoCarro;
				}
                                if($i%13 == 6){
					$promo->precio = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
				}
				if($i%13 == 7){
					$promo->iva = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
				}
                                if($i%13 == 8){
					$promo->margenLP = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
				}
                                if($i%13== 9){
					$promo->dcoFeria = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
				}
                                if($i%13 == 10){
					$promo->vigencia = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();   
				}
                                if($i%13 == 11){
                                    $promo->plazo = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                }
                                if($i%13 == 12){
                                    $promo->condiciones = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                    if($promo->precio && $promo->categoria){
                                            $b = floor($i/13);
                                            $product = $products[$b];
                                            $product->items[] = $promo;
//                                            echo $product->items[0]->categoria.'<br/>';
//                                            echo $product->items[0]->incluye.'<br/>';
//                                            echo $product->items[0]->taller.'<br/>';
//                                            echo $product->items[0]->marca.'<br/>';
//                                            echo $product->items[0]->tipoCarro.'<br/>';
//                                            echo $product->items[0]->precio.'<br/>';
//                                            echo $product->items[0]->iva.'<br/>';
//                                            echo $product->items[0]->margenLP.'<br/>';
//                                            echo $product->items[0]->dcoFeria.'<br/>';
//                                            echo $product->items[0]->vigencia.'<br/>';
//                                            echo $product->items[0]->plazo.'<br/>';
//                                            echo $product->items[0]->condiciones.'<br/>';
                                            $promo = NULL;
                                    } 
                                }
                                
				$i++;
			}
				
				
			
			$cellIterator->next();
		}
	}
}