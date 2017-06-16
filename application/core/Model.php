<?php

class Model {
	public $archives = array("01"=>"Letters", "02"=>"Articles", "03"=>"Books", "04"=>"Photographs", "05"=>"Brochures", "06"=>"Miscellaneous", "07"=>"Unsorted");
	public function __construct() {

		$this->db = new Database();
	}

	public function getPostData() {

		if (isset($_POST['submit'])) {

			unset($_POST['submit']);	
		}

		if(!array_filter($_POST)) {
		
			return false;
		}
		else {

			return array_filter(filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS));
		}
	}

	public function getGETData() {

		if(!array_filter($_GET)) {
		
			return false;
		}
		else {

			return filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
		}
	}

	public function preProcessPOST ($data) {

		return array_map("trim", $data);
	}

	public function encrypt ($data) {

		return sha1(SALT.$data);
	}
	
	public function sendLetterToPostman ($fromName = SERVICE_NAME, $fromEmail = SERVICE_EMAIL, 
		$toName = SERVICE_NAME, $toEmail = SERVICE_EMAIL, $subject = 'Bounce', 
		$message = '', $successMessage = 'Bounce', $errorMessage = 'Error') {

	    $mail = new PHPMailer();
        $mail->isSendmail();
        $mail->isHTML(true);
        $mail->setFrom($fromEmail, $fromName);
        $mail->addReplyTo($fromEmail, $fromName);
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        return $mail->send();
 	}

 	public function bindVariablesToString ($str = '', $data = array()) {

 		unset($data['count(*)']);
	    
	    while (list($key, $val) = each($data)) {
	    
	        $str = preg_replace('/:'.$key.'/', $val, $str);
		}
	    return $str;
 	}

	public function getAlbumDetails($albumID) {

		$dbh = $this->db->connect(DB_NAME);
		if(is_null($dbh))return null;
		
		$sth = $dbh->prepare('SELECT * FROM ' . METADATA_TABLE_L1 . ' WHERE albumID = :albumID');
		$sth->bindParam(':albumID', $albumID);

		$sth->execute();
		
		$result = $sth->fetch(PDO::FETCH_OBJ);
		$dbh = null;
		return $result;
	}

	public function getLetterDetails($albumID, $id) {

		$dbh = $this->db->connect(DB_NAME);
		if(is_null($dbh))return null;
		
		$sth = $dbh->prepare('SELECT * FROM ' . METADATA_TABLE_L2 . ' WHERE albumID = :albumID AND id = :id');
		$sth->bindParam(':albumID', $albumID);
		$sth->bindParam(':id', $id);
		$sth->execute();
		
		$result = $sth->fetch(PDO::FETCH_OBJ);
		$dbh = null;

		return $result;
	}

	public function getNeighbourhood($id) {
		$ids = preg_split('/__/', $id);
		$archives = array("01"=>"Letters", "02"=>"Articles", "03"=>"Books", "04"=>"Photographs", "05"=>"Brochures", "06"=>"Miscellaneous", "07"=>"Unsorted");
        $atype = $archives[$ids[0]];
		$albumID = $ids[1];
		$albumPath = PHY_ARCHIVES_URL . $atype . '/' . $albumID;

		$actualID = $ids[2];

		$letterPath = $albumPath . "/" . $actualID . '.json';
		// var_dump($letterPath);

		$files = glob($albumPath . "/*" . '.json');
		// var_dump($files);
		$match = array_search($letterPath, $files);

		if(!($match === False)){
			
			$data['prev'] = (isset($files[$match-1])) ? preg_replace("/.*\/(.*)\.json/", "$1", $files[$match-1]) : '';
			$data['next'] = (isset($files[$match+1])) ? preg_replace("/.*\/(.*)\.json/", "$1", $files[$match+1]) : '';

			return $data;
		}
		else{

			return False;
		}

	}
	public function getArchiveType($combinedID) {

		$ids = preg_split('/__/', $combinedID);
		$archives = array("01"=>"Letters", "02"=>"Articles", "03"=>"Books", "04"=>"Photographs", "05"=>"Brochures", "06"=>"Miscellaneous", "07"=>"Unsorted");
		return $archives[$ids[0]];
    }

    public function getActualID($combinedID) {

        return preg_replace('/^(.*)__/', '', $combinedID);
    }

    public function getRandomImage($id){

        $photos = glob(PHY_PHOTO_URL . $id . '/thumbs/*.JPG');
        $randNum = rand(0, sizeof($photos) - 1);
        $photoSelected = $photos[$randNum];

        return str_replace(PHY_PHOTO_URL, PHOTO_URL, $photoSelected);   	
    }

    public function getPhotoCount($id = '') {

        $count = sizeof(glob(PHY_PHOTO_URL . $id . '/*.json'));
        return ($count > 1) ? $count . ' Photographs' : $count . ' Photograph';
    }

    public function getDetailByField($json = '', $firstField = '', $secondField = '') {

        $data = json_decode($json, true);

        if (isset($data[$firstField])) {
      
            return $data[$firstField];
        }
        elseif (isset($data[$secondField])) {
      
            return $data[$secondField];
        }

        return '';
    }
    
    public function getAlbumID($combinedID) {

        return preg_replace('/^(.*)__/', '', $combinedID);
    }
    
    public function includeRandomThumbnail($id = '') {
		
		$archiveType = $this->getArchiveType($id);
		$id = $this->getAlbumID($id);
		if($archiveType == 'Photographs')
		{
			$letters = glob(PHY_ARCHIVES_URL . $archiveType . '/' . $id . '/*.JPG');
			$letterSelected = $letters[0];
			return str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $letterSelected);
		}
		else
		{
			$letters = glob(PHY_ARCHIVES_URL . $archiveType . '/' . $id . '/*',GLOB_ONLYDIR);
        
			$randNum = rand(0, 0);
			$letterSelected = $letters[$randNum];
			$pages = glob($letterSelected . '/thumbs/*.JPG');
			//~ $randNum = rand(0, sizeof($pages) - 1);
			$randNum = rand(0, 0);
			$pageSelected = $pages[$randNum];

			return str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $pageSelected);
		}

        return str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $pageSelected);
    }
    
    public function getLettersCount($id = '') {

			$archiveType = $this->getArchiveType($id);
			$archivePath = PHY_ARCHIVES_URL . $archiveType . "/";
			$albumID = $this->getAlbumID($id);

			$count = sizeof(glob($archivePath . $albumID . '/*.json'));
			if($archiveType == "Letters")
			{
				return ($count > 1) ? $count . ' Letters' : $count . ' Letter';
			}
			elseif($archiveType == "Articles")
			{
				return ($count > 1) ? $count . ' Articles' : $count . ' Article';
			}
			elseif($archiveType == "Brochures")
			{
				return ($count > 1) ? $count . ' Brochures' : $count . ' Brochure';
			}
			elseif($archiveType == "Books")
			{
				return ($count > 1) ? $count . ' Books' : $count . ' Book';
			}
			elseif($archiveType == "Photographs")
			{
				return ($count > 1) ? $count . ' Photos' : $count . ' Photo';
			}
			else
			{
				return ($count > 1) ? $count . ' Items' : $count . ' Item';
			}
    }
    public function getPath($combinedID){
		$archiveType = $this->getArchiveType($combinedID);
		$ids = preg_split('/__/', $combinedID);
		$ActualPath = PHY_ARCHIVES_URL . $archiveType . '/' . $ids[1] . '/' . $ids[2];
		return $ActualPath;
    }
    public function includeRandomThumbnailFromArchive($id = '') {
        
        $archiveType = $this->getArchiveType($id);
		if($archiveType == 'Photographs')
		{
			$ids = preg_split('/__/', $id);
			$ActualPath = PHY_ARCHIVES_URL . $archiveType . '/' . $ids[1] . '/thumbs/' . $ids[2] . '.JPG';
			return str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $ActualPath);
		}
		else
		{        
			$imgPath = $this->getPath($id);
			$pages = glob($imgPath .  '/thumbs/*.JPG');
			$randNum = rand(0, 0);
			$pageSelected = $pages[$randNum];

			return str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $pageSelected);
		}
    }
    
}

?>
