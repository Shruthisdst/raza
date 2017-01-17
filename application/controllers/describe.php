<?php

class describe extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function index() {

		$this->photo();
	}

	public function letter($albumID = DEFAULT_ALBUM, $id = '') {

		$data = $this->model->getLetterDetails($albumID, $id);
		$data->neighbours = $this->model->getNeighbourhood($albumID, $id);
		
		($data) ? $this->view('describe/letter', $data) : $this->view('error/index');
	}
}

?>