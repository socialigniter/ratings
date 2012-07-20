<h2 class="content_title"><img src="<?= $modules_assets ?>ratings_32.png"> Ratings</h2>
<ul class="content_navigation">
	<?= navigation_list_btn('home/ratings', 'Recent') ?>
	<?= navigation_list_btn('home/ratings/custom', 'Custom') ?>
	<?php if ($logged_user_level_id <= 2) echo navigation_list_btn('home/ratings/manage', 'Manage', $this->uri->segment(4)) ?>
</ul>