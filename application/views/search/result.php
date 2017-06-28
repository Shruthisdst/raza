<?php $description = $data["sterm"]; unset($data["sterm"]); ?>

<script>
$(document).ready(function(){

    var processing = false;
    var description = <?php echo  '"' . $description . '"';  ?>;
    function getresult(url) {
        processing = true;
        $.ajax({
            url: url,
            type: "GET",
            complete: function(){
                $('#loader-icon').hide();
            },
            success: function(data){
                processing = true;
                // console.log(data);
                var gutter = parseInt(jQuery('.post').css('marginBottom'));
                var $grid = $('#posts').masonry({
                    gutter: gutter,
                    itemSelector: '.post',
                    columnWidth: '.post'
                });
                var obj = JSON.parse(data);
                var displayString = "";
                for(i=0;i<Object.keys(obj).length-2;i++)
                {                    
                    displayString = displayString + '<div class="post">';    
                    displayString = displayString + '<a href="' + <?php echo '"' . BASE_URL . '"'; ?> + 'describe/archive/' + obj[i].albumID + '/' + obj[i].id + '" title="View Details">';
                    displayString = displayString + '<img class="img-responsive" src="' +  obj[i].image + '">';
                    if(JSON.parse(obj[i].description).title)
                    {
						displayString = displayString + '<p class="image-desc">';
						displayString = displayString + '<strong>' + JSON.parse(obj[i].description).title + '</strong>';
						displayString = displayString + "</p>";
					}
                    displayString = displayString + '</div>';
                    displayString = displayString + '</a>';
                    displayString = displayString + '</div>';
                }

                var $content = $(displayString);
                $content.css('display','none');
                $grid.append($content).imagesLoaded(
                    function(){
                        $content.fadeIn(500);
                        $grid.masonry('appended', $content);
                        processing = false;
                    }
                );

               displayString = "";
               $("#hidden-data").append(obj.hidden);
            },
            error: function(){console.log("Fail");}             
      });
    }
    $(window).scroll(function(){
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.65){
            if($(".lastpage").length == 0){
                var pagenum = parseInt($(".pagenum:last").val()) + 1;
                if(!processing)
                {
                    getresult(base_url+'search/field/?page='+pagenum+'&description='+description);
                }
            }
        }
    });
});
</script>
<?php 
	$hiddenData = $data["hidden"]; 
	unset($data["hidden"]);
?>
<div id="grid" class="container-fluid">
    <div id="posts">       
<?php foreach ($data as $row) { ?>
        <div class="post">
            <?php $actualID = $viewHelper->getAlbumID($row->id); ?>
            <a href="<?=BASE_URL?>describe/archive/<?=$row->albumID . '/' . $row->id?>" title="View Details">
                <img src="<?=$viewHelper->includeRandomThumbnailFromArchive($row->id)?>">
                <?php
                    $caption = $viewHelper->getDetailByField($row->description, 'Caption');
                    if ($caption) echo '<p class="image-desc"><strong>' . $caption . '</strong></p>';
                ?>
            </a>
        </div>
<?php } ?>
    </div>
</div>
<div id="hidden-data">
    <?php echo $hiddenData; ?>
</div>
<div id="loader-icon"><img src="<?=STOCK_IMAGE_URL?>loading.gif" /><div>
