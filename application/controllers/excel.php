<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja la página principal
 */
class Excel extends Laspartes_Controller{
	
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
		$this->load->view('excel/form', $data);
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
			
			$this->load->view('excel/success', $data);
		}
	}
	
	function _processProducts(&$products, $id_establecimiento){
		$this->load->model('excel_model');
		foreach($products as $product){ 
			foreach($product->items as $item){
                                echo 'entro a procesar';
				if($item->marca == "FABRICA"){
					$item->marca = "Equipo Original";
				}
				$autoparte = $this->excel_model->dar_autoparte($id_establecimiento, $product->name, $item->marca, $item->precio);
                                echo 'lista la autoparte<br/>';
				if(!$autoparte){
//                                        echo 'entro a !autoparte<br/>';
					$marca = $this->excel_model->dar_marca_autoparte($item->marca);
					$this->excel_model->agregar_establecimiento_autoparte($id_establecimiento, $product->name, $marca, $item->precio, $item->ano_inicio, $item->ano_fin, $item->original, $item->observacion, $item->categoria, $item->origen, $item->descripcion);
					$autoparte = $this->excel_model->dar_autoparte($id_establecimiento, $product->name, $item->marca, $item->precio);
//                                        echo 'autoparte:'.$autoparte->id_autoparte.'<br/>';
				}
				$item->autoparte = $autoparte->id_autoparte;
				$vehiculo = $this->_dar_vehiculo($item->vehiculo, $item->marcavehiculo);
				if($vehiculo){
					$item->id_vehiculo = $vehiculo->id_vehiculo;
					$item->marca_vehiculo = $vehiculo->marca;
					$item->linea_vehiculo = $vehiculo->linea;
					
					$est = $this->excel_model->dar_autoparte_vehiculo($autoparte->id_autoparte, $vehiculo->id_vehiculo);
					if(!$est){
						$this->excel_model->agregar_autoparte_vehiculo($autoparte->id_autoparte, $vehiculo->id_vehiculo);
						$est = $this->excel_model->dar_autoparte_vehiculo($autoparte->id_autoparte, $vehiculo->id_vehiculo);
					}
					if(!$est){
						var_dump($item);
						//exit();
					}
				}
			}
		}
	}
	
	function _dar_vehiculo($linea, $marca){
		$this->load->model('excel_model');
		
		//exit();
		return $this->excel_model->dar_vehiculo($linea, $marca);
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
		
		$vehicle = NULL;
		while($cellIterator->valid()){
			$cell = $cellIterator->current();
			
			if($index == 0){
				$value = $cell->getValue();
				if(strlen($value) > 0 && ($value != "SI" && $value != "NO")){
					$p = new stdClass();
					$p->name = $value;
					$p->items = array();
					$products[$i] = $p;
					$i++;
				}
			}else{
				
				if(!$vehicle){
					$vehicle = new stdClass();
				}
				
				if($i%10 == 0){
					$vehicle->marcavehiculo = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'marca: '.$vehicle->marcavehiculo.'<br/>';
				}
				if($i%10 == 1){
					$vehicle->vehiculo = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'vehiculo: '.$vehicle->vehiculo.'<br/>';
				}
                                if($i%10 == 2){
					$anios = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        list($inicio, $fin) = split('-',$anios);
                                        $vehicle->ano_inicio = $inicio;
                                        $vehicle->ano_fin = $fin;
                                        echo 'ano_inicio: '.$vehicle->ano_inicio.'<br/>';
                                        echo 'ano_fin: '.$vehicle->ano_fin.'<br/>';
				}
				if($i%10 == 3){
					$vehicle->original = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'original: '.$vehicle->original.'<br/>';
				}
				if($i%10 == 4){
					$vehicle->marca = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        if($vehicle->marca == '' || strlen($vehicle->marca) == 0){
                                                $vehicle->marca = 'genérica';
                                        }
                                        echo 'marca: '.$vehicle->marca.'<br/>';
				}
                                if($i%10 == 5){
					$vehicle->origen = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'origen: '.$vehicle->origen.'<br/>';
				}
				if($i%10 == 6){
					$vehicle->precio = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'precio: '.$vehicle->precio.'<br/>';
				}
                                if($i%10 == 7){
					$vehicle->observacion = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'observacion: '.$vehicle->observacion.'<br/>';
				}
                                if($i%10== 8){
					$vehicle->categoria = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'categoria: '.$vehicle->categoria.'<br/>';
				}
                                if($i%10 == 9){
					$vehicle->descripcion = $sheet->getCellByColumnAndRow($i, $cell->getRow())->getCalculatedValue();
                                        echo 'descripcion: '.$vehicle->descripcion.'<br/>';
                                    if($vehicle->marca && $vehicle->precio){
                                            $b = floor($i/10);
                                            $product = $products[$b];
                                            $product->items[] = $vehicle;
                                            $vehicle = NULL;
                                            $vehicle = new stdClass();
                                            echo 'finalizo: <br/>';
                                    }    
				}
                                
				$i++;
			}
			
			$cellIterator->next();
		}
	}
}