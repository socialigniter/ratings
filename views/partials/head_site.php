<script type="text/javascript">
$(document).ready(function()
{
	// Simple
	$('.ratings_vote').live('click', function(e)
	{
		e.preventDefault();
		if ($(this).data('authentication') == true)
		{
			var vote_data = new Array;
			vote_data.push({'name':'object','value':$(this).data('object')});
			vote_data.push({'name':'object_id','value':$(this).data('object_id')});
			vote_data.push({'name':'type','value':$(this).data('type')});
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
				  	console.log(result);
				  	$('#content_message').notify({scroll:true,status:result.status,message:result.message});									

			  	}		
			});
		}
		else
		{
			alert('You must be logged in to vote on this');
		}
	});

});
</script>