<?php


class listingModel extends Model {

	public function __construct() {

		parent::__construct();
	}

	public function listAlbums($type, $pagedata) {
		
		$perPage = 10;

		$page = $pagedata["page"];

		$start = ($page-1) * $perPage;

		if($start < 0) $start = 0;
		
		$dbh = $this->db->connect(DB_NAME);
		if(is_null($dbh))return null;
		
		$sth = $dbh->prepare('SELECT * FROM ' . METADATA_TABLE_L1 . ' WHERE albumID LIKE \''. $type . '__%\' ORDER BY albumID' . ' limit ' . $start . ',' . $perPage);
		
		$sth->execute();
		$data = array();
		
		while($result = $sth->fetch(PDO::FETCH_OBJ)) {
			
			$result->randomImagePath = $this->includeRandomThumbnail($result->albumID);
			$result->leafCount = $this->getLeafCount($result->albumID);
			$result->field = $this->getDetailByField($result->description, 'Title');
			$result->description = json_decode($result->description);

			array_push($data, $result);
		}
		$dbh = null;
		
		$data = array_filter($data);
		
		if(!empty($data)){

			// $data["hidden"] = '<input type="hidden" class="pagenum" value="' . $page . '" />';
			$data['Archive'] = $type;
		}
		else{

			$data = 'noData';
		}
		
		return $data;
	}

	public function listArchives($albumID,$pagedata) {

		$perPage = 10;

		$page = $pagedata["page"];

		$start = ($page-1) * $perPage;

		if($start < 0) $start = 0;

		$dbh = $this->db->connect(DB_NAME);
		
		if(is_null($dbh)) return null;
		
		$sth = $dbh->prepare('SELECT * FROM ' . METADATA_TABLE_L2 . ' WHERE albumID = :albumID ORDER BY id' . ' limit ' . $start . ',' . $perPage);
		$sth->bindParam(':albumID', $albumID);

		$sth->execute();
		$data = array();
		
		while($result = $sth->fetch(PDO::FETCH_OBJ)) {

			$result->randomImagePath = $this->includeRandomThumbnailFromArchive($result->id);
			$result->field = $this->getDetailByField($result->description, 'title');
			array_push($data, $result);
		}

		$dbh = null;
		
		if(!empty($data)) {
			
			$data['albumDetails'] = $this->getAlbumDetails($albumID);
		}
		else {

			$data = 'noData';
		}
		
		return $data;
	}
	
	public function listCollections($archive) {
		
		$collectionsFile = JSON_PRECAST_URL . $this->archives[$archive] . ".json";
		$jsonData = file_get_contents($collectionsFile);
		$data = json_decode($jsonData,true);
		return $data;
	}
	
}

?>
