<?php
	$albumDetails = $data['albumDetails']; unset($data['albumDetails']);
	$albumID = $data[0]->albumID;
?>

<div id="grid" class="container-fluid">
    <div id="posts">
        <div class="post no-border">
            <div class="image-desc-full">
				<?=$viewHelper->displayFieldData($albumDetails->description)?>
                <?php if(isset($_SESSION['login'])) {?>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?=BASE_URL?>edit/archives/<?=$data[0]->albumID?>" class="btn btn-primary" role="button">Contribute</a>
                    </li>    
                </ul>    
                <?php } ?>
            </div>
        </div>
<?php foreach ($data as $row) { ?>
        <div class="post">
			<a href="<?=BASE_URL?>describe/archive/<?=$row->albumID . '/' . $row->id?>" title="View Details">
			<img src="<?=$viewHelper->listPhotosFromArchive($row->id)?>">                
            </a>
        </div>
<?php } ?>
    </div>
</div>

<div id="loader-icon"><img src="<?=STOCK_IMAGE_URL?>loading.gif" /><div>
