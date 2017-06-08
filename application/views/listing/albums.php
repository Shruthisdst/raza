<?php
	$archive = $data['Archive'];
	unset($data['Archive']);
?>

<div class="container">
    <div class="row first-row">
        <!-- Column 1 -->
        <div class="col-md-12 text-center">
            <ul class="list-inline sub-nav">
                <li><a href="<?=BASE_URL?>listing/albums/<?=LETTERS?>">Letters</a></li>
                <li><a>·</a></li>
                <li><a href="<?=BASE_URL?>listing/albums/<?=ARTICLES?>">Articles</a></li>
                <li><a>·</a></li>
                <li><a href="<?=BASE_URL?>listing/collections/<?=BOOKS?>">Books</a></li>
                <li><a>·</a></li>
                <li><a href="<?=BASE_URL?>listing/archives/<?=PHOTOGRAPHS?>__001">Photographs</a></li>
                <li><a>·</a></li>
                <li><a href="<?=BASE_URL?>listing/archives/<?=BROCHURES?>__001">Brochures</a></li>
                <li><a>·</a></li>
                <li><a href="<?=BASE_URL?>listing/albums/<?=MISCELLANEOUS?>">Miscellaneous</a></li>
                <li><a>·</a></li>
                <li><a href="<?=BASE_URL?>listing/albums/<?=UNSORTED?>">Unsorted</a></li>
                <li><a>·</a></li>
                <li><a>Search</a></li>
                <li id="searchForm">
                    <form class="navbar-form" role="search" action="<?=BASE_URL?>search/field/" method="get">
                        <div class="input-group add-on">
                            <input type="text" class="form-control" placeholder="Keywords" name="description" id="description">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    var processing = false;
    var archive = <?php echo  '"' . $archive . '"';  ?>;

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
                 //console.log(data);
                var gutter = parseInt(jQuery('.post').css('marginBottom'));
                var $grid = $('#posts').masonry({
                    gutter: gutter,
                    // specify itemSelector so stamps do get laid out
                    itemSelector: '.post',
                    columnWidth: '.post',
                });
                var obj = JSON.parse(data);
                var displayString = "";
                
                for(i=0;i<Object.keys(obj).length-2;i++)
                {                    
                    // console.log(obj[i].Randomimage);    
                    // console.log(JSON.parse(obj[i].description).Title);

                    displayString = displayString + '<div class="post">';
                    displayString = displayString + '<a href="' + <?php echo '"' . BASE_URL . '"'; ?> + 'listing/archives/' + obj[i].albumID + '" title="View Album">';
                    displayString = displayString + '<div class="fixOverlayDiv">';
                    displayString = displayString + '<img class="img-responsive" src="' + obj[i].Randomimage + '">';
                    displayString = displayString + '<div class="OverlayText">' + obj[i].Photocount + '<br /><span class="link"><i class="fa fa-link"></i></span></div>';
                    displayString = displayString + '</div>';
                    displayString = displayString + '<p class="image-desc">';
                    displayString = displayString + '<strong>' + JSON.parse(obj[i].description).Title + '</strong>';
                    displayString = displayString + "</p>";
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
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())* 0.65){
            if($(".lastpage").length == 0){
                var pagenum = parseInt($(".pagenum:last").val()) + 1;
                
                 //~ console.log(base_url+'listing/albums/' + archive + '/?page='+pagenum);
                if(!processing)
                {
                    getresult(base_url + 'listing/albums/' + archive + '/?page='+pagenum);
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
            <a href="<?=BASE_URL?>listing/archives/<?=$row->albumID?>" title="View Album">
                <div class="fixOverlayDiv">
                    <img class="img-responsive" src="<?=$viewHelper->includeRandomThumbnail($row->albumID)?>">
                    <div class="OverlayText"><?=$viewHelper->getLettersCount($row->albumID)?><br /><span class="link"><i class="fa fa-link"></i></span></div>
                </div>
                <p class="image-desc">
                    <strong><?=$viewHelper->getDetailByField($row->description, 'Title')?></strong>
                </p>
            </a>
        </div>
<?php } ?>
    </div>
</div>
<div id="hidden-data">
    <?php echo $hiddenData; ?>
</div>
<div id="loader-icon"><img src="<?=STOCK_IMAGE_URL?>loading.gif" /><div>
