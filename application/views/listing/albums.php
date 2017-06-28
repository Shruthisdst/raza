<?php
	$archive = $data['Archive'];
	unset($data['Archive']);
?>

<script>
$(document).ready(function(){

    $(window).scroll(function(){

        if ($(window).scrollTop() >= ($(document).height() - $(window).height())* 0.75){

            if($('#grid').attr('data-go') == '1') {

                var pagenum = parseInt($('#grid').attr('data-page')) + 1;
                $('#grid').attr('data-page', pagenum);

                getresult(base_url + 'listing/albums/' + '<?=$archive?>' + '/?page='+pagenum);
            }
        }
    });
});     
</script>

<div id="grid" class="container-fluid" data-page="1" data-go="1">
    <div id="posts">

<?php foreach ($data as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>listing/archives/<?=$row->albumID?>" title="View Album">
                <div class="fixOverlayDiv">
                    <img class="img-responsive" src="<?=$row->randomImagePath?>">
                    <div class="OverlayText"><?=$row->leafCount?><br /><span class="link"><i class="fa fa-link"></i></span></div>
                </div>
                <?php if($row->field) { ?><p class="image-desc"><strong><?=$row->field?></strong></p><?php } ?>
            </a>
        </div>
<?php } ?>
    </div>
</div>
<div id="loader-icon">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br />
    Loading more items
</div>
