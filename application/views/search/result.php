<?php $description = $data["description"]; unset($data["description"]); ?>

<script>
$(document).ready(function(){

    $('.post.no-border').prepend('<div class="albumTitle Search"><span><i class="fa fa-search"></i> ' + '<?=$description?>' + '</span></div>');

    $(window).scroll(function(){

        if ($(window).scrollTop() >= ($(document).height() - $(window).height())* 0.75){

            if($('#grid').attr('data-go') == '1') {

                var pagenum = parseInt($('#grid').attr('data-page')) + 1;
                $('#grid').attr('data-page', pagenum);

                getresult(base_url + 'search/field/?page=' + pagenum + '&description=' + '<?=$description?>');
            }
        }
    });
});     
</script>

<div id="grid" class="container-fluid" data-page="1" data-go="1">
    <div id="posts">
        <div class="post no-border"></div>
<?php foreach ($data as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>describe/archive/<?=$row->albumID . '/' . $row->id?>" title="View Details">
                <img src="<?=$row->randomImagePath?>">
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
