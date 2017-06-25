
$(document).ready(function()
{
  startTime();
});



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
        calcTotalExit($(this), true);
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
$('.tcard form .parameter').bind('mousewheel', function(e)
{
  var myInput = $(this).find('input[type="number"]');
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
    $setResult = calcTotalExit(_target.parents('.tcard'));
    if($setResult === 0)
    {
      setExtraInvalid(_target);
    }
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
function calcTotalExit(_card, _recalc)
{
  // get plus and minus
  var plus  = parseInt(_card.find('.timePlus').attr('data-val')) || 0;
  var minus = parseInt(_card.find('.inputMinus').val()) || 0;
  // check recalc all
  if(_recalc)
  {
    var enter = _card.find('.timeEnter').attr('data-val');
    var exit  = _card.find('.timeNow').attr('data-val');
    // calc diff from time of server
    var denter = new Date(enter);
    var dexit  = new Date(exit);
    // diff in minute
    var diff   = Math.floor((dexit- denter)/1000/60);
    _card.find('.timeDiff').attr('data-val', diff).text(diff);
    // set max with maximum of total tile
    var maxAllowed = Math.ceil(diff/10)*10;
    _card.find('.inputMinus').attr('max', maxAllowed);
  }
  else
  {
    var diff  = parseInt(_card.find('.timeDiff').attr('data-val')) || 0;
  }
  // calc finalTime
  var finalTime = diff + plus - minus;
  // set value if time pure
  if(finalTime < 0)
  {
    finalTime = 0;
  }
  _card.find('.timePure').attr('data-val', finalTime).text(finalTime);
  return finalTime;
}



/**
 * [startTime description]
 * @return {[type]} [description]
 */
function startTime()
{
  var today = new Date();

  changetime(addZero(today.getSeconds()), 'second');
  changetime(addZero(today.getMinutes()), 'minute');
  changetime(today.getHours(), 'hour');
  var t = setTimeout(startTime,500);
}


/**
 * [addZero description]
 * @param {[type]} i [description]
 */
function addZero(i)
{
  if (i < 10)
  {
    i = "0" + i
  };
  return i;
}


/**
 * [changetime description]
 * @param  {[type]} _new   [description]
 * @param  {[type]} _class [description]
 * @return {[type]}        [description]
 */
function changetime(_value, _class)
{
  _new = String(_value);
  // change time to persian if we are in rtl design
  if($('body').hasClass('rtl'))
  {
    // convert time to persian
    persian={0:'۰',1:'۱',2:'۲',3:'۳',4:'۴',5:'۵',6:'۶',7:'۷',8:'۸',9:'۹'};
    for(var i=0; i<=9; i++)
    {
        var re = new RegExp(i,"g");
        _new = _new.replace(re, persian[i]);
    }
  }
  // if time is not changed, return false
  if($('.time .'+ _class).attr('data-time') == _value)
  {
    return false;
  }
  // set new value with effect
  $('.time .'+ _class).html(_new).attr('data-time', _value);
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

