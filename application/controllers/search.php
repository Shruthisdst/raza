<?php

class search extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function index() {

		$this->field();
	}

	public function field() {
		
		$data = $this->model->getGetData();
		unset($data['url']);

		// Check if any data is posted. For this journal name should be excluded.
		if($data) {

			if(!(isset($data["page"]))){
			
				$data["page"] = 1;
			}
	
			$perPage = 10;

			$page = $data["page"];

			unset($data['page']);

			$data = $this->model->preProcessPOST($data);

			$limit = ' LIMIT ' . ($page - 1) * $perPage . ', ' . $perPage;

			$query = $this->model->formGeneralQuery($data, METADATA_TABLE_L2,'',$limit);

			// var_dump($query);
			$result = $this->model->executeQuery($query);
			if(!empty($result)){

				$result["hidden"] = '<input type="hidden" class="pagenum" value="' . $page . '" />';
				// var_dump($result);
			}
			else{

				$result["hidden"] = '<div class="lastpage"></div>';
			}

			$result['sterm'] = $data["description"];

			if($page == 1){

				($result)? $this->view('search/result', $result) : $this->view('error/noResults', 'search/index/');
			}
			else{
				echo json_encode($result);
			}
		}
		else {

			$this->view('error/index');
		}
	}
}

?>
