$(document).ready(function()
{	
	// Loop Through Votes
	$.each(<?= $json_votes ?>, function(key, value)
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

	// Simple
	$('.ratings_vote').bind('click', function(e)
	{
		e.preventDefault();
		if ($(this).data('authentication') == true)
		{
			var vote_data = new Array;
			vote_data.push({'name':'object','value':$(this).parent().data('object')});
			vote_data.push({'name':'object_id','value':$(this).parent().data('object_id')});
			vote_data.push({'name':'type','value':$(this).parent().data('type')});
			vote_data.push({'name':'rating','value':$(this).data('rating')});

			$.oauthAjax(
			{
				oauth 		: user_data,		
				url			: base_url + 'api/ratings/create_vote',
				type		: 'POST',
				dataType	: 'json',
				data		: vote_data,
			  	success		: function(result)
			  	{				  	
				  	if (result.status == 'success')
				  	{
				  		renderVoteStatus($('.ratings_vote'), result.rating.rating);
				  	}
			  	}		
			});
		}
		else
		{
			alert('You must be logged in to vote on this');
		}
	});	
	
	function renderVoteStatus(elements, rating)
	{
	  	$.each(elements, function(index, value)
	  	{ 
	  		if ($(this).data('rating') == rating)
		  	{
		  		$(this).removeClass('vote_no').addClass('vote_yes');
		  	}
		  	else
		  	{
			  	$(this).removeClass('vote_yes').addClass('vote_no');
		  	}
		});	
	}
	
});