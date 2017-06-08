<?php


class listing extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function index() {

		$this->albums();
	}

	public function albums($defaultType = DEFAULT_TYPE) {
		
		$data = $this->model->getGetData();
		unset($data['url']);
		
		if(!(isset($data["page"]))){
		
			$data["page"] = 1;
		
		}

		$result = $this->model->listAlbums($defaultType, $data);
		
		
		if($data["page"] == 1){
		
			($result) ? $this->view('listing/albums', $result) : $this->view('error/index');
		}
		else{
		
			echo json_encode($result);
		
		}
	}

	public function archives($album = DEFAULT_ALBUM) {
		
		$data = $this->model->getGetData();
		
		unset($data['url']);
		
		if(!(isset($data["page"]))){
		
			$data["page"] = 1;
		
		}

		$result = $this->model->listArchives($album,$data);

		if($data["page"] == 1){
		
			($result) ? $this->view('listing/archives', $result) : $this->view('error/index');
		}
		else{
			
			echo json_encode($result);
		}
		
	}
	
	public function collections($archive){
		
		//~  Album id for book archive is hardcoded, have to change
		$result = $this->model->listCollections($archive);
		($result) ? $result['albumID'] = "03__001" and $this->view('listing/collections', $result) : $this->view('error/index');
	}
}

?>
