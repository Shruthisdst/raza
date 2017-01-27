<?php

class data extends Controller {

	public function __construct() {
		
		parent::__construct();
	}

	public function index() {

		$this->insertPhotoDetails();
	}

	public function insertDetails(){

		$this->model->db->createDB(DB_NAME, DB_SCHEMA);
		$dbh = $this->model->db->connect(DB_NAME);

		$this->model->db->dropTable(METADATA_TABLE_L1, $dbh);
		$this->model->db->createTable(METADATA_TABLE_L1, $dbh, METADATA_TABLE_L1_SCHEMA);

		$this->model->db->dropTable(METADATA_TABLE_L2, $dbh);
		$this->model->db->createTable(METADATA_TABLE_L2, $dbh, METADATA_TABLE_L2_SCHEMA);

		$this->model->db->createTable(METADATA_TABLE_L3, $dbh, METADATA_TABLE_L3_SCHEMA);
		$this->model->db->createTable(METADATA_TABLE_L4, $dbh, METADATA_TABLE_L4_SCHEMA);
		
		//List albums
		$archives = array("01"=>"Letters", "02"=>"Articles", "04"=>"Miscellaneous", "05"=>"Unsorted");
		foreach($archives as $key => $value)
		{
			$archivePath = PHY_PUBLIC_URL . $value . "/";
		
			$albums = $this->model->listFiles($archivePath, 'json');
			if($albums) {

				$this->model->insertAlbums($key, $albums, $dbh);

				foreach ($albums as $album) {

					// List files
					$letters = $this->model->listFiles(str_replace('.json', '/', $album), 'json');

					if($letters) {

						$this->model->insertLetters($key, $letters, $dbh);
					}
					else{

						echo 'Album ' . $album . ' does not have any letters' . "\n";
					}
				}
			}
			else{

				echo 'No albums to insert';
			}
		}
		$dbh = null;
	}
	
	public function updateAlbumJson($albumIdWithType) {
		
		$data = $this->model->getPostData();
		$fileContents = array();
		
		foreach($data as $value){

			$fileContents[$value[0]] = $value[1];
		}
		$archiveType = $this->model->getArchiveType($albumIdWithType);

		$albumID = $fileContents['albumID'];

		$path = PHY_PUBLIC_URL . $archiveType . '/'. $albumID . ".json";
		
		$albumUrl = BASE_URL . 'listing/archives/' . $albumIdWithType;
		
		$fileContents = json_encode($fileContents,JSON_UNESCAPED_UNICODE);


		if(file_put_contents($path, $fileContents))
		{
			$this->updateAlbumDetails($albumIdWithType, $fileContents);
			$this->view('data/albumDataUpdated');
		}
		else
		{
			$this->view('data/writeerror');
		}

	}
	
	private function updateAlbumDetails($albumIdWithType, $fileContents){
		
		$dbh = $this->model->db->connect(DB_NAME);
		$this->model->db->updateAlbumDescription($albumIdWithType, $fileContents, $dbh);
		$this->model->updateDetailsForEachArchive($albumIdWithType, $fileContents, $dbh);
	}
	
	public function updateJson($albumIdWithType) {
		
		$data = $this->model->getPostData();
		$fileContents = array();

		foreach($data as $value){

			$fileContents[$value[0]] = $value[1];
		}
		$archiveType = $this->model->getArchiveType($albumIdWithType);

		$albumID = $fileContents['albumID'];
		$archiveID = $albumIdWithType . '__' . $fileContents['id'];

		$path = PHY_PUBLIC_URL . $archiveType . '/'. $albumID . '/' . $fileContents['id'] . ".json";
		$albumUrl = BASE_URL . 'listing/archives/' . $albumIdWithType;

		$fileContents = json_encode($fileContents,JSON_UNESCAPED_UNICODE);

		if(file_put_contents($path, $fileContents))
		{
			$this->view('data/archiveDataUpdated');
			$this->updateArchiveDetails($archiveID,$albumIdWithType,$fileContents);
		}
		else
		{
			$this->view('data/writeerror');
		}
	}

	private function updateArchiveDetails($archiveID,$albumIdWithType,$fileContents){

			$dbh = $this->model->db->connect(DB_NAME);
			$albumDescription = $this->model->getAlbumDetails($albumIdWithType);
			$albumDescription = $albumDescription->description;
			$archiveDescription = $fileContents;

			$combinedDescription = json_encode(array_merge(json_decode($archiveDescription, true), json_decode($albumDescription, true)));

			$this->model->db->updateArchiveDescription($archiveID,$albumIdWithType,$combinedDescription,$dbh);

	}
}

?>
