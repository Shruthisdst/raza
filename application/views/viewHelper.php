<?php

class viewHelper extends View {

    public function __construct() {

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

    public function getLettersCount($id = '') {
			$ids = preg_split('/__/', $id);
			$archives = array("01"=>"Letters", "02"=>"Articles");
			$atype = $archives[$ids[0]];
			$archivePath = PHY_PUBLIC_URL . $atype . "/";
			$count = sizeof(glob($archivePath . $ids[1] . '/*.json'));
			if($atype == "Letters")
			{
				return ($count > 1) ? $count . ' Letters' : $count . ' Letter';
			}
			elseif($atype == "Articles")
			{
				return ($count > 1) ? $count . ' Articles' : $count . ' Article';
			}
		
    }

    public function getActualID($combinedID) {

        return preg_replace('/^(.*)__/', '', $combinedID);
    }
    public function getType($combinedID) {
		

        return preg_replace('/(.*)__(.*)/', '$1', $combinedID);
    }
    
    public function getAlbumID($combinedID){

        return preg_replace('/__(.*)/', '', $combinedID);
    }

    public function includeRandomThumbnail($id = '') {
		$archives = array("01"=>"Letters", "02"=>"Articles");
		$archiveType = $this->getType($id);
		$atype = $archives[$archiveType];
		$id = $this->getActualID($id);
        $letters = glob(PHY_PUBLIC_URL . $atype . '/' . $id . '/*',GLOB_ONLYDIR);
        
        $randNum = rand(0, sizeof($letters) - 1);
        $letterSelected = $letters[$randNum];
        $pages = glob($letterSelected . '/thumbs/*.JPG');
        $randNum = rand(0, sizeof($pages) - 1);
        $pageSelected = $pages[$randNum];

        return str_replace(PHY_PUBLIC_URL, PUBLIC_URL, $pageSelected);
    }

    public function includeRandomThumbnailFromLetter($id = '') {
		
        $ids = preg_split('/__/', $id);
        $archives = array("01"=>"Letters", "02"=>"Articles");
        $atype = $archives[$ids[0]];
        $pages = glob(PHY_PUBLIC_URL . $atype . '/' . $ids[1] . '/' . $ids[2] .  '/thumbs/*.JPG');
        $randNum = rand(0, sizeof($pages) - 1);
        $pageSelected = $pages[$randNum];

        return str_replace(PHY_PUBLIC_URL, PUBLIC_URL, $pageSelected);
    }

    public function displayFieldData($json, $auxJson='') {

        $data = json_decode($json, true);
        
        if ($auxJson) $data = array_merge($data, json_decode($auxJson, true));

        $pdfFilePath = '';
        if(isset($data['id'])) {
			
            $actualID = $this->getActualID($data['id']);
            if($data['Type'] == "Letter")
            {
				$pdfFilePath = LETTERS_URL . $data['albumID'] . '/' . $actualID . '/index.pdf';
			}
			elseif($data['Type'] == "Article")
			{
				$pdfFilePath = ARTICLES_URL . $data['albumID'] . '/' . $actualID . '/index.pdf';
			}
            
            $data['id'] = $data['albumID'] . '/' . $data['id'];
            unset($data['albumID']);
        }

        $html = '';
        $html .= '<ul class="list-unstyled">';

        foreach ($data as $key => $value) {

            if($value){

                if(preg_match('/keyword/i', $key)) {

                    $html .= '<li class="keywords"><strong>' . $key . ':</strong><span class="image-desc-meta">';
                    
                    $keywords = explode(',', $value);
                    foreach ($keywords as $keyword) {
       
                        $html .= '<a href="' . BASE_URL . 'search/field/?description=' . $keyword . '">' . str_replace(' ', '&nbsp;', $keyword) . '</a> ';
                    }
                    
                    $html .= '</span></li>' . "\n";
                }
                else{

                    $html .= '<li><strong>' . $key . ':</strong><span class="image-desc-meta">' . $value . '</span></li>' . "\n";
                }
            }    
        }

        // $html .= '<li>Do you know details about this picture? Mail us at heritage@iitm.ac.in quoting the image ID. Thank you.</li>';

        if($pdfFilePath != ''){
            $html .= '<li><a href="'.$pdfFilePath.'" target="_blank">Click here to view PDF</a></li>'; 
        }

        $html .= '</ul>';

        return $html;
    }

    public function displayThumbs($id){
		$ids = preg_split('/__/', $id);
		$archives = array("01"=>"Letters", "02"=>"Articles");
        $atype = $archives[$ids[0]];
        //~ $albumID = $this->getAlbumID($id);
        //~ $letterID = $this->getActualID($id);
        $filesPath = PHY_PUBLIC_URL . $atype . '/' . $ids[1] . '/' . $ids[2] . '/thumbs/*' . PHOTO_FILE_EXT;
        $files = glob($filesPath);


        echo '<div id="viewletterimages" class="letter_thumbnails">';
        foreach ($files as $file) {

            $mainFile = $file;
            $mainFile = preg_replace('/thumbs\//', '', $mainFile);
            echo '<span class="img-small">';

            echo '<img class="img-responsive" data-original="'.str_replace(PHY_PUBLIC_URL, PUBLIC_URL, $mainFile).'" src="' . str_replace(PHY_PUBLIC_URL, PUBLIC_URL, $file) . '" >';

            echo '</span>';
        }
        // echo $albumID . '->' . $letterID;
        echo '</div>';

    }


    public function insertReCaptcha() {

        require_once('vendor/recaptchalib.php');

        $publickey = "6Le_DBsTAAAAACt5YrgWhjW00CcAF0XYlA30oLPc";
        $privatekey = "6Le_DBsTAAAAAH8rvyqjPXU9jxY5YJxXct76slWv";

        echo recaptcha_get_html($publickey);
    }

}

?>
