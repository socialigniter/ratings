<div class="<?= $class ?>" id="vote_<?= $object_id ?>" data-object="<?= $object ?>" data-object_id="<?= $object_id ?>" data-type="two" data-voter_ids='<?= $voter_ids ?>'>
	<div class="ratings_vote_container">
		<a href="#" id="vote_up_<?= $object_id ?>" class="ratings_vote vote_up vote_unvoted" data-authentication="true" data-rating="up"><span>Vote Up</span></a>
		<div class="vote_count_yes" id="vote_count_up_<?= $object_id ?>"><?= $up_votes ?></div>
	</div>
	<div class="ratings_vote_container">
		<a href="#" id="vote_down_<?= $object_id ?>" class="ratings_vote vote_down vote_unvoted" data-authentication="true" data-rating="down"><span>Vote Down</span></a>
		<div class="vote_count_no" id="vote_count_down_<?= $object_id ?>"><?= $down_votes ?></div>
	</div>
</div>