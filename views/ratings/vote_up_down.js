function renderVotesMultiple(element)
{
	$.each($(element), function()
	{
		var voter_ids	= $(this).data('voter_ids');
		var voter_vote	= voter_ids[user_data.user_id];
		var object_id	= $(this).data('object_id');

		if (voter_vote != undefined)
		{		
			$('#vote_' + voter_vote + '_' + object_id).removeClass('vote_unvoted').addClass('vote_voted');
		}
	});
	
	return false;
}	


function renderVoteSingle(rating_data)
{
	$.each(rating_data, function(key, value)
	{
		if (value.user_id == user_data.user_id)
		{
			$.each($('.ratings_vote'), function()
			{
				if ($(this).data('rating') == value.rating)
				{
					renderVoteStatus($('.ratings_vote'), value.rating);
				}
			});
		}
	});
}


function renderVoteStatus(rating, count)
{	
	var this_votes = $('#vote_' + rating.object_id).find('.ratings_vote');

	if (rating.rating == 'up') var rating_remove = 'down';
	else var rating_remove = 'up';
	
	$('#vote_' + rating.rating + '_' + rating.object_id).removeClass('vote_unvoted').addClass('vote_voted');
	$('#vote_' + rating_remove + '_' + rating.object_id).removeClass('vote_voted').addClass('vote_unvoted');
	
	$('#vote_count_up_' + rating.object_id).html(count.up);
	$('#vote_count_down_' + rating.object_id).html(count.down);	
}

$(document).ready(function()
{
	
	// Do Rating
	$('.ratings_vote').bind('click', function(e)
	{
		e.preventDefault();
		if ($(this).data('authentication') == true)
		{
			var vote_data 	= new Array;
			var object_id	= $(this).parent().parent().data('object');
			var object		= $(this).parent().parent().data('object_id');
			var type 		= $(this).parent().parent().data('type');
			var rating		= $(this).data('rating');

			vote_data.push({'name':'object','value':object_id});
			vote_data.push({'name':'object_id','value':object});
			vote_data.push({'name':'type','value':type});
			vote_data.push({'name':'rating','value':rating});
			vote_data.push({'name':'authentication','value':'yes'});

			$.oauthAjax(
			{
				oauth 		: user_data,
				url			: base_url + 'api/ratings/create_vote',
				type		: 'POST',
				dataType	: 'json',
				data		: vote_data,
			  	success		: function(result)
			  	{	
			  		console.log(result);
			  				  	
				  	if (result.status == 'success')
				  	{
				  		renderVoteStatus(result.rating, result.count);
				  	}
			  	}		
			});
		}
		else
		{
			alert('You must be logged in to vote on this');
		}
	});
	
});