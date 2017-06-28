<?php

	$albumID = $data['albumID'];
	$sumne = explode('__', $albumID);
	$archive = $sumne[0];
	unset($data['albumID']);
	
?>

<div id="grid" class="container-fluid">
    <div id="posts">
        <div class="post no-border">
            <div class="image-desc-full">
				<p class="image-desc">
                    <strong><?=$data['name']?></strong>
                </p>
                
                <?php if(isset($_SESSION['login'])) {?>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?=BASE_URL?>edit/archives/<?=$albumID?>" class="btn btn-primary" role="button">Contribute</a>
                    </li>    
                </ul>    
                <?php } ?>
            </div>
        </div>
<?php foreach ($data['details'] as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>describe/archive/<?=$albumID . '/' . $albumID . "__" . $row['id']?>" title="View Details">
                <img src="<?=$viewHelper->includeRandomThumbnailFromArchive($albumID . "__" . $row['id'])?>">
                <p class="image-desc">
                    <strong><?=$row['title']?></strong>
                </p>
            </a>
        </div>
<?php } ?>
    </div>
</div>
