<div class="block">
	<h3>Reviews</h3>
	<div class="review_tablemenu">
	    <?php
	    foreach($user->getAllUserReviewsMenukaart() as $ad){
	        ?>
	        <div class="Reviews">
	            <p class="title"><span class="bold">Titel: <?=$ad['title'];?><br> Review: <?=$ad['description'];?></span><br> Score: <?=$ad['rating'];?><br> Geschreven Door <?=$ad['firstname'];?> <?=$ad['lastname'];?></p>
	        </div>
	    <?php
	    }
	    ?>
	</div>
</div>