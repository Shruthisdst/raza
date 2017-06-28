<?php
	$albumID = $data['albumID'];
	$sumne = explode('__', $albumID);
	$archive = $sumne[0];
	unset($data['albumID']);
?>
<div id="grid" class="container-fluid">
    <div id="posts">
<?php foreach ($data as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>describe/collections/<?=$archive?>/<?=$row['collectionID']?>" title="View Collections">
                <div class="fixOverlayDiv">
                    <img class="img-responsive" src="<?=$viewHelper->includeRandomThumbnailFromArchive($albumID . "__" . $row['booklist'][rand(0, count($row['booklist'])-1)])?>">
                    <div class="OverlayText"><?=count($row['booklist'])?> <?= count($row['booklist']) > 1 ?  'Books'  : 'Book' ?><br /><span class="link"><i class="fa fa-link"></i></span></div>
                </div>
                <p class="image-desc">
                    <strong><?=$row['name']?></strong>
                </p>
            </a>
        </div>
<?php } ?>
    </div>
</div>
