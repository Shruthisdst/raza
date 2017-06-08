<?php

	$albumID = $data['albumID'];
	$sumne = explode('__', $albumID);
	$archive = $sumne[0];
	unset($data['albumID']);
	
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
                <li><a href="<?=BASE_URL?>listing/archives/<?=BOOKS?>__001">Books</a></li>
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
<div id="grid" class="container-fluid">
    <div id="posts">
        <div class="post no-border">
            <div class="image-desc-full">
                <?=$data['name']?>
                <?php if(isset($_SESSION['login'])) {?>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?=BASE_URL?>edit/archives/<?=$albumID?>" class="btn btn-primary" role="button">Contribute</a>
                    </li>    
                </ul>    
                <?php } ?>
            </div>
        </div>
<?php foreach ($data['booklist'] as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>describe/archive/<?=$albumID . '/' . $albumID . "__" . $row?>" title="View Details">
                <img src="<?=$viewHelper->includeRandomThumbnailFromArchive($albumID . "__" . $row)?>">
            </a>
        </div>
<?php } ?>
    </div>
</div>
