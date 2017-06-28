<div class="container">
    <div class="row gap-above-med">
        <div class="col-md-9">
            <ul class="pager">
                <?php if($data->neighbours['prev']) {?> 
                <li class="previous"><a href="<?=BASE_URL?>describe/archive/<?=$data->albumID?>/<?=$data->albumID . '__' . $data->neighbours['prev']?>">&lt; Previous</a></li>
                <?php } ?>
                <?php if($data->neighbours['next']) {?> 
                <li class="next"><a href="<?=BASE_URL?>describe/archive/<?=$data->albumID?>/<?=$data->albumID . '__' . $data->neighbours['next']?>">Next &gt;</a></li>
                <?php } ?>
            </ul>
            <?php $actualID = $viewHelper->getAlbumID($data->id); ?>
            <?php $viewHelper->displayThumbs($data->id); ?>
        </div>            
        <div class="col-md-3">
            <div class="image-desc-full">
                <ul class="list-unstyled">
                    <?=$viewHelper->displayFieldData($data->description)?>
                    <?php if(isset($_SESSION['login'])) {?>
                    <li>
                            <a href="<?=BASE_URL?>edit/archive/<?=$data->albumID?>/<?=$data->id?>" class="btn btn-primary" role="button">Contribute</a>
                    </li>                
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=PUBLIC_URL?>js/viewer.js"></script>
