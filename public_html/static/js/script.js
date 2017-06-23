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
			// add flip to this card
			$(this).addClass('flipped');

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

