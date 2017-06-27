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
                <li><a href="<?=BASE_URL?>listing/albums/<?=PHOTOGRAPHS?>">Photographs</a></li>
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
    var archive = "<?=$archive?>";

    function getresult(url) {
        processing = true;
        $.ajax({
            url: url,
            type: "GET",
            
            beforeSend: function(){

                $('#loader-icon').show();
            },
            success: function(data){
                
                processing = true;

                if(data == "\"noData\"") {

                    $('#grid').append('<div id="no-more-icon">No more<br />items<br />to show</div>');
                    $('#loader-icon').hide();
                    return;
                }

                var gutter = parseInt(jQuery('.post').css('marginBottom'));
                var $grid = $('#posts').masonry({
                    gutter: gutter,
                    // specify itemSelector so stamps do get laid out
                    itemSelector: '.post',
                    columnWidth: '.post',
                });

                var obj = JSON.parse(data);
                var displayString = "";
                
                for(i=0;i<Object.keys(obj).length-1;i++)
                {

                    displayString += '<div class="post">';
                    displayString += '<a href="' + <?php echo '"' . BASE_URL . '"'; ?> + 'listing/archives/' + obj[i].albumID + '" title="View Album">';
                    displayString += '<div class="fixOverlayDiv">';
                    displayString += '<img class="img-responsive" src="' + obj[i].randomImagePath + '">';
                    displayString += '<div class="OverlayText">' + obj[i].leafCount + '<br /><span class="link"><i class="fa fa-link"></i></span></div>';
                    displayString += '</div>';
                    displayString += '<p class="image-desc">';
                    displayString += '<strong>' + obj[i].field + '</strong>';
                    displayString += "</p>";
                    displayString += '</a>';
                    displayString += '</div>';
                }

                var $content = $(displayString);
                $content.css('display','none');

                $grid.append($content).imagesLoaded(
                    function(){
                        $content.fadeIn(500);
                        $grid.masonry('appended', $content);
                        $('#loader-icon').hide();
                        processing = false;
                    }
                );

                displayString = "";
            },
            error: function(){console.log("Fail");}             
      });
    }
    $(window).scroll(function(){
        
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())* 0.75){

            if(!processing) {

                var pagenum = parseInt($('#grid').attr('data-page')) + 1;
                $('#grid').attr('data-page', pagenum);

                getresult(base_url + 'listing/albums/' + archive + '/?page='+pagenum);
            }
        }
    });
});     
</script>

<div id="grid" class="container-fluid" data-page="1">
    <div id="posts">

<?php foreach ($data as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>listing/archives/<?=$row->albumID?>" title="View Album">
                <div class="fixOverlayDiv">
                    <img class="img-responsive" src="<?=$row->randomImagePath?>">
                    <div class="OverlayText"><?=$row->leafCount?><br /><span class="link"><i class="fa fa-link"></i></span></div>
                </div>
                <p class="image-desc">
                    <strong><?=$row->field?></strong>
                </p>
            </a>
        </div>
<?php } ?>
    </div>
</div>
<div id="loader-icon">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br />
    Loading more items
</div>
