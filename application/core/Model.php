<?php

class Model {
	public $archives = array("01"=>"Letters", "02"=>"Articles", "03"=>"Books", "04"=>"Photographs", "05"=>"Brochures", "06"=>"Miscellaneous", "07"=>"Unsorted", "08"=>"Artworks");
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
		$archives = array("01"=>"Letters", "02"=>"Articles", "03"=>"Books", "04"=>"Photographs", "05"=>"Brochures", "06"=>"Miscellaneous", "07"=>"Unsorted", "08"=>"Artworks");
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
		$archives = array("01"=>"Letters", "02"=>"Articles", "03"=>"Books", "04"=>"Photographs", "05"=>"Brochures", "06"=>"Miscellaneous", "07"=>"Unsorted", "08"=>"Artworks");
		return $archives[$ids[0]];
    }

    public function getActualID($combinedID) {

        return preg_replace('/^(.*)__/', '', $combinedID);
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
    
    public function getLeafCount($id = '') {

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
			elseif($archiveType == "Artworks")
			{
				return ($count > 1) ? $count . ' Works' : $count . ' Work';
			}
			else
			{
				return ($count > 1) ? $count . ' Items' : $count . ' Item';
			}
    }
    public function getPath($combinedID){

		$archiveType = $this->getArchiveType($combinedID);
		$ids = preg_split('/__/', $combinedID);
		$actualPath = PHY_ARCHIVES_URL . $archiveType . '/' . $ids[1] . '/' . $ids[2];
		return $actualPath;
    }

    public function getArtefactThumbnail($id = ''){

        $archiveType = $this->getArchiveType($id);
		$imgPath = $this->getPath($id);

		if((preg_match('/^' . PHOTOGRAPHS . '__/', $id)) || (preg_match('/^' . ARTWORKS . '__/', $id))) {

			$thumbnailPath = preg_replace("/(.*)\/(.*)/", "$1/thumbs/$2.JPG", $imgPath);
		}
		else{

			$pages = glob($imgPath .  '/thumbs/*.JPG');
			$thumbnailPath = (isset($pages[0])) ? $pages[0] : '';
		}

		return (file_exists($thumbnailPath)) ? str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $thumbnailPath) : STOCK_IMAGE_URL . 'default-image.png';
    }

    public function getRandomArtefact($albumID = '') {
		

		$archiveType = $this->getArchiveType($albumID);

		$path = PHY_ARCHIVES_URL . $archiveType . '/' . $this->getAlbumID($albumID) . '/';

		$artefacts = ((preg_match('/^' . PHOTOGRAPHS . '__/', $albumID)) || (preg_match('/^' . ARTWORKS . '__/', $albumID))) ? glob($path . '*.JPG') : glob($path . '*', GLOB_ONLYDIR);

		$randNum = rand(0, sizeof($artefacts) - 1);

		$randomArtefact = (isset($artefacts[$randNum])) ? $albumID . '__' . str_replace($path, '', $artefacts[$randNum]) : $albumID . '__' . DEFAULT_ARTEFACT;
		return str_replace('.JPG', '', $randomArtefact);
    }
}

?>
