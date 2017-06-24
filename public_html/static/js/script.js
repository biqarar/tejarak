
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
      unflipAllCards();

      if($(this).attr('data-status') === 'active')
      {
        // add flip to this card
        $(this).addClass('flipped');
        calcTotalExit($(this));
      }
      else
      {
        console.log('this user is deactive!');
      }
    }
  }
});


/**
 * unflip all cards
 * @return {[type]} [description]
 */
function unflipAllCards()
{
  // remove flip of all other cards
  $('.tcard').removeClass('flipped');
  $('.tcard input:not([type="hidden"])').val('');
}




$('.tcard form [data-connect]').on('click', function()
{
  var myInput = $(this).parent().find('input');
  var extra   = parseInt($(this).attr('data-val')) || 0;
  // add this value to target
  setExtra(myInput, extra);
});



// up and down minus with scrool
$('.tcard form').bind('mousewheel', function(e)
{
  var myInput = $('.tcard form input[type="number"]');
  if(e.originalEvent.wheelDelta /120 > 0)
  {
    setExtra(myInput, true);
  }
  else{
    setExtra(myInput, false);
  }
});


/**
 * [setExtra description]
 * @param {[type]} _target [description]
 * @param {[type]} _extra  [description]
 * @param {[type]} _exact  [description]
 */
function setExtra(_target, _extra, _exact)
{
  var newVal  = parseInt(_target.val()) || 0;
  if(_extra === true)
  {
    _extra = 5;
  }
  else if(_extra === false)
  {
    _extra = -5;
  }
  else if(_extra === null)
  {
    _extra = 0;
    _exact = true;
  }
  //  if exact copy value else plus it
  if(_exact)
  {
    newVal = parseInt(_extra);
  }
  else
  {
    newVal += parseInt(_extra);
  }
  console.log(newVal);

  if(_target.attr('min') && newVal < parseInt(_target.attr('min')))
  {
    // do nothing
    setExtraInvalid(_target);
  }
  else if(_target.attr('max') && newVal > parseInt(_target.attr('max')))
  {
    // do nothing
    setExtraInvalid(_target);
  }
  else
  {
    _target.val(newVal);
    calcTotalExit(_target.parents('.tcard'));
  }

}


/**
 * [setExtraInvalid description]
 * @param {[type]} _target [description]
 */
function setExtraInvalid(_target)
{
  $(_target).addClass('invalid');
  setTimeout(function()
  {
    $(_target).removeClass('invalid');
  }, 300);
}


/**
 * [calcTotalExit description]
 * @return {[type]} [description]
 */
function calcTotalExit(_card)
{
  var enter = _card.find('.timeEnter').attr('data-val');
  var exit  = _card.find('.timeNow').attr('data-val');
  var diff  = parseInt(_card.find('.timeDiff').attr('data-val')) || 0;
  var plus  = parseInt(_card.find('.timePlus').attr('data-val')) || 0;
  var minus = parseInt(_card.find('.inputMinus').val()) || 0;

  // calc diff from time of server

  var finalTime = diff + plus - minus;
   _card.find('.timePure').attr('data-val', finalTime).text(finalTime);

  console.log(enter);
  console.log(exit);
  console.log(diff);
  console.log(plus);
  console.log(minus);
  console.log(finalTime);
}




$('body').on('click', function(e, f, a)
{
  if($(e.target).parents('.tcard').is($('.tcard')))
  {

  }
  else
  {
    unflipAllCards();
  }
})

