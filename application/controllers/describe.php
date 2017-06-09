<?php

class describe extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function index() {

		$this->photo();
	}

	public function archive($albumID = DEFAULT_ALBUM, $id = '') {

		$data = $this->model->getLetterDetails($albumID, $id);
		$data->neighbours = $this->model->getNeighbourhood($id);
		
		($data) ? $this->view('describe/archive', $data) : $this->view('error/index');
	}
	
	public function collections($archive, $collectionID) {
		
		$data = $this->model->getCollectionList($archive, $collectionID);
		$data['albumID'] = $archive . '__001';
		
		($data) ? $this->view('describe/collections', $data) : $this->view('error/index');
	}
}

?>
