$('.tcard').on('click', function()
{
	// if tcard has back
	if($(this).find('.back').length)
	{
		if($(this).hasClass('flipped'))
		{
			// $(this).removeClass('flipped');
		}
		else
		{
			// remove flip of all other cards
			$('.tcard').removeClass('flipped');

			if($(this).attr('data-status') === 'active')
			{
				// add flip to this card
				$(this).addClass('flipped');
			}
			else
			{
				console.log('this user is deactive!');
			}
		}
	}
});

$('body').on('click', function(e, f, a)
{
	if($(e.target).parents('.tcard').is($('.tcard')))
	{

	}
	else
	{
		$('.tcard').removeClass('flipped');
	}

})

