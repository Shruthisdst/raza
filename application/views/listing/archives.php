<?php
	$albumDetails = $data['albumDetails']; unset($data['albumDetails']);
	$albumID = $data[0]->albumID;
    $archiveType = $viewHelper->getArchiveType($albumID);
?>

<script>
$(document).ready(function(){

    $('.post.no-border').prepend('<div class="albumTitle <?=$archiveType?>"><span><?=$archiveType?></span></div>');

    $(window).scroll(function(){

        if ($(window).scrollTop() >= ($(document).height() - $(window).height())* 0.75){

            if($('#grid').attr('data-go') == '1') {

                var pagenum = parseInt($('#grid').attr('data-page')) + 1;
                $('#grid').attr('data-page', pagenum);

                getresult(base_url + 'listing/archives/' + '<?=$albumID?>' + '/?page='+pagenum);
            }
        }
    });
});     
</script>

<div id="grid" class="container-fluid" data-page="1" data-go="1">
    <div id="posts">
        <div class="post no-border">
            <div class="image-desc-full">
                <?=$viewHelper->displayFieldData($albumDetails->description)?>
                <?=$viewHelper->includeEditButton($albumID)?>
            </div>
        </div>
<?php foreach ($data as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>describe/archive/<?=$row->albumID . '/' . $row->id?>" title="View Details">
                <img src="<?=$row->randomImagePath?>">
                <?php if($row->field) { ?><p class="image-desc"><?=$row->field?></p><?php } ?>
            </a>
        </div>
<?php } ?>
    </div>
</div>
<div id="loader-icon">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br />
    Loading more items
</div>
