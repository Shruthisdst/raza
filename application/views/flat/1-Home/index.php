<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="container-fluid" id="home">
    <div class="row first-row">
        <div class="col-md-12 clear-paddings">
            <div class="fixOverlayDiv">
                <img class="img-responsive gap-above" src="<?=PUBLIC_URL?>images/stock/slide.jpg">
                <div class="OverlayTextMain">
                    <div class="mainpage">
						<h1>The Raza Foundation</h1>
						<p>Raza Foundation is an arts and culture organization under the guidance of Mr. S. H. Raza who sets an example where fame and glory are not lonesome attainments but things to be liberally shared with the broader creative community. The Foundation has been instrumental in creating spaces for various art and culture programs, publications and fellowships to the younger talent and also carrying a deeper research into the work of the masters.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" id="about">
    <div class="row">
		<div class="col-md-1"></div>
        <div class="col-md-10">
			<h2>S. H. Raza</h2><hr />
			<p>Born in 1922, Babaria (Madhya Pradesh), Raza graduated from Sir J. J. School of Arts, Mumbai in 1943 and became one of the founding members of Progressive Artists Group in 1947. He received the French Government Scholarship in 1950 to study at Ecole Nationale des Beaux-Arts in Paris. In his long career, Raza has held several solo and group exhibitions in India and abroad which include Biennale de Venice, 1956; Biennale de Menton, 1964, 66, 68, 72 &amp; 76; Biennale du Moroc, Rabat, 1963; Biennale, Bharat Bhavan, Bhopal, 1986; Biennial of Havana, 1987; Jane Woorhese Zimmerli Art Museum, New Jersey, 2002; Swasti, NGMA, New Delhi, 2007. Several publications have been released on his life and work which include Bindu: Space and Time in Raza’s Vision by Geeti Sen, 1997; Raza by Ashok Vajpeyi, 2002 and A Life in Art: Raza written &amp; edited by Ashok Vajpeyi, 2007. He is a recipient of Prix de la Critique (Paris, 1956); the Rajkeeya Samman and Kalidas Samman (Government of Madhya Pradesh, 1978 &amp; 1997); and Officier de LOrdre Des Arts et des Lettres (Government of France, 2002). The Government of India conferred him with the Padma Shri in 1981 and the Padma Bhushan in 2007. He was also honoured with the Fellowship of the Lalit Kala Akademi in 1983. After sixty years of living in France Raza returned to India in December 2010 and now lives and works in New Delhi.</p>
			<p id="right"><a href="<?=BASE_URL?>The_Raza_Foundation">More ...</a></p>
         </div>
         <div class="col-md-1"></div>
    </div>    
</div>

<div class="container-fluid stats" id="collection">
    <div class="row">
        <div class="col-md-12">
            <h1>The Collection</h1>
            <ul class="list-inline">
                <li class="stat-elem">
                    <a href="<?=BASE_URL?>listing/albums">
                        <h2><i class="fa fa-envelope"></i></h2>
                        <p>Letters</p>
                    </a>
                </li>
                <li class="stat-elem">
                    <a href="#">
                        <h2><i class="fa fa-file-text-o"></i></h2>
                        <p>Articles</p>
                    </a>
                </li>
                <li class="stat-elem">
                    <a href="#">
                        <h2><i class="fa fa-volume-up"></i></h2>
                        <p>Multimedia</p>
                    </a>
                </li>
                <li class="stat-elem">
                    <a href="<?=BASE_URL?>Oral_History">
                        <h2><i class="fa fa-image"></i></h2>
                        <p>Photographs</p>
                    </a>
                </li>
                <li class="stat-elem">
                    <a href="#">
                        <h2><i class="fa fa-book"></i></h2>
                        <p>Books</p>
                    </a>
                </li>
                <li class="stat-elem">
                    <a href="#">
                        <h2><i class="fa fa-th"></i></h2>
                        <p>Miscellaneous</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid physical" id="physical">
</div>

<div class="container-fluid" id="contact">
    <div class="row first-row">
        <div class="col-md-12 clear-paddings">
            <div class="fixOverlayDiv">
                <img class="img-responsive gap-above" src="<?=PUBLIC_URL?>images/stock/slide2.jpg">
                <div class="OverlayTextMain">
                    <div class="mainpage">
                        <h2>Contact</h2><br />
                        <form method="post" action="<?=BASE_URL . 'mail/send'?>">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required">
                            </div>
                            <div class="form-group">
                                <textarea rows="5" class="form-control" name="message" id="message" placeholder="Your message here" required="required"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Le_DBsTAAAAACt5YrgWhjW00CcAF0XYlA30oLPc"></div>
                            </div>
                            <button type="submit" class="btn btn-default naked email-submit">Submit</button>
                        </form>
                        <p>
                            <br /><br /><small>
                                Copyright © 2016 - All Rights Reserved - The Raza Foundation<br />
<!--
                                No image available from this site may be used for commercial purposes without written permission from JSS Mahavidyapeetha.
-->
                            </small><br />
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=PUBLIC_URL?>js/common.js" async></script>
