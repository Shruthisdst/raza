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

    public function getAlbumID($combinedID) {

        return preg_replace('/^(.*)__/', '', $combinedID);
    }
    
    public function getActualID($combinedID) {

        return preg_replace('/^(.*)__(.*)/', '', $combinedID);
    }

    public function getArchiveType($combinedID) {

		$ids = preg_split('/__/', $combinedID);
		$archives = array("01"=>"Letters", "02"=>"Articles", "03"=>"Books", "04"=>"Photographs", "05"=>"Brochures", "06"=>"Miscellaneous", "07"=>"Unsorted");
		return $archives[$ids[0]];
    }
    
    public function getArchivePath($aPath) {

		if($aPath == "Letter")
        {
			$ArchivePath = LETTERS_URL;
		}
		elseif($aPath == "Article")
		{
			$ArchivePath = ARTICLES_URL;
		}
		elseif($aPath == "Book")
		{
			$ArchivePath = BOOKS_URL;
		}
		elseif($aPath == "Brochure")
		{
			$ArchivePath = BROCHURES_URL;
		}
		elseif($aPath == "Miscellaneous")
		{
			$ArchivePath = MISCELLANEOUS_URL;
		}
		elseif($aPath == "Unsorted")
		{
			$ArchivePath = UNSORTED_URL;
		}
		elseif($aPath == "Photographs")
		{
			$ArchivePath = UNSORTED_URL;
		}
		return $ArchivePath;
    }

    public function getPath($combinedID){
		$archiveType = $this->getArchiveType($combinedID);
		$ids = preg_split('/__/', $combinedID);
		$ActualPath = PHY_ARCHIVES_URL . $archiveType . '/' . $ids[1] . '/' . $ids[2];
		return $ActualPath;
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

    public function displayFieldData($json, $auxJson='') {

        $data = json_decode($json, true);
        
        if ($auxJson) $data = array_merge($data, json_decode($auxJson, true));

        $pdfFilePath = '';
        if(isset($data['id'])) {
			
            $actualID = $this->getAlbumID($data['id']);
            $ArchivePath = $this->getArchivePath($data['Type']);
			$pdfFilePath = $ArchivePath . $data['albumID'] . '/' . $actualID . '/index.pdf';
			$phypdfFilePath = str_replace(ARCHIVES_URL, PHY_ARCHIVES_URL, $pdfFilePath);
            
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

        if(isset($phypdfFilePath) && file_exists($phypdfFilePath)){
            $html .= '<li><a href="'.$pdfFilePath.'" target="_blank">Click here to view PDF</a></li>'; 
        }
        $html .= '</ul>';

        return $html;
    }

    public function displayThumbs($id){
		
		$archiveType = $this->getArchiveType($id);
		if($archiveType == 'Photographs')
		{
			$ids = preg_split('/__/', $id);
			 echo '<div id="viewletterimages" class="image-full-size">';
             echo '<img class="img-responsive" src="' . PHOTO_URL . $ids[1] . '/' . $ids[2] . '.JPG">';
             echo '</div>';
		}
		else
		{
			$imgPath = $this->getPath($id);
			$filesPath = $imgPath . '/thumbs/*' . PHOTO_FILE_EXT;
			$files = glob($filesPath);
		

			echo '<div id="viewletterimages" class="letter_thumbnails">';
			foreach ($files as $file) {

				$mainFile = $file;
				$mainFile = preg_replace('/thumbs\//', '', $mainFile);
				//~ echo '<span class="img-small">';

				echo '<img class="img-small img-responsive" data-original="'.str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $mainFile).'" src="' . str_replace(PHY_ARCHIVES_URL, ARCHIVES_URL, $file) . '" >';

				//~ echo '</span>';
			}
			 
			echo '</div>';
		}

    }


    public function insertReCaptcha() {

        require_once('vendor/recaptchalib.php');

        $publickey = "6Ld9gRQUAAAAABN0ern9If3yH1cIXlKV19TXu5Wj";
        $privatekey = "6Ld9gRQUAAAAAJ7NKpEvpqlVStQk45SoPUGK1DO9";

        echo '<div class="g-recaptcha" data-sitekey="'. $publickey . '"></div>';
    }
    
    public function displayDataInForm($json, $auxJson='') {

        $data = json_decode($json, true);
        
        if ($auxJson) $data = array_merge($data, json_decode($auxJson, true));
        
        $count = 0;
        $formgroup = 0;

        foreach ($data as $key => $value) {
             //~ echo "Key: $key; Value: $value\n";
             if($key == 'albumID') {
				if (preg_match('/__/', $value)) {
				$id = preg_split('/__/', $value);
				$value = $id[1];
				}
			 }
            $disable = (($key == 'id') || ($key == 'albumID'))? 'readonly' : '';
            echo '<div class="form-group" id="frmgroup' . $formgroup . '">' . "\n";
            echo '<input type="text" class="form-control" name="id'. $count . '[]"  value="' . $key . '"' . $disable  . ' />&nbsp;' . "\n";
            echo '<input type="text" class="form-control" name="id'. $count . '[]"  value="' . $value . '"' . $disable . ' />' . "\n";
            if($disable != "readonly"){
                echo '<input type="button"  onclick="removeUpdateDataElement(\'frmgroup'. $formgroup .'\')" value="Remove" />' . "\n";                
            }
            echo '</div>' . "\n";
            $count++;
            $formgroup++;
        }

        echo '<div id="keyvalues">' . "\n";
        echo '</div>' . "\n";
        echo '<input type="button" id="keyvaluebtn" onclick="addnewfields(keyvaluebtn)" value="Add New Fields" />' . "\n";
        echo '<input type="submit" id="submit" value="Update Data" />' . "\n";
    }

}

?>
