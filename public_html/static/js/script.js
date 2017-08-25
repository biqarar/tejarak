// on start
route('*', function ()
{

}).once(function()
{
  setLanguageURL();

});


$(document).ready(function()
{
  checkAndRunAttendance();
  homepageCases();
});


// ---------------------------------------------------------------------- Attendance Page
/**
 * check and if we are in attendance page run needed code
 * @return {[type]} [description]
 */
function checkAndRunAttendance()
{
  if($('body').hasClass('attendance'))
  {
    checkResolution();
    checkResize();
    startClock();
    bindExtraInput();
    runLoadCard();
    changeCardStatusOnResult();
  }
}


function checkResize()
{
  $( window ).resize(function() {
    if($('body').hasClass('attendance'))
    {
      checkResolution();
    }
  });
}

function checkResolution()
{
  var myBox       = $('#content');
  var myBoxHeight = Math.floor(myBox.height() * 0.8);
  var myBoxWidth  = Math.floor(myBox.width() * 0.9);
  var myBoxDim    = myBoxHeight * myBoxWidth;
  // console.log(myBoxDim);

  var myBoard  = $('#showMember');
  var personCount = $('#showMember a').length;
  var bestChoice  = '';

  var sizes =
  {
    mini:     35 * 150,
    tiny:     40 * 180,
    small:    50 * 200,
    normal:   240 * 200,
    large:    270 * 220,
    big:      300 * 250,
    huge:     360 * 300,
    massive:  470 * 400,
  };

  $.each(sizes, function(_cls, _val)
  {
    var canShow = Math.floor( (myBoxDim/_val)*0.7 );
    // if work not good can uncomment below code
    // canShow = canShow -1;
    // console.log(myBoxDim/_val);
    // console.log((myBoxDim/_val)*0.7);
    // console.log(Math.floor( (myBoxDim/_val)*0.7 ));

    if(canShow > personCount)
    {
      // console.log(_cls);
      bestChoice = _cls;
    }
  });
  // set default size if not exist
  if(!bestChoice)
  {
    bestChoice = 'mini';
  }
  // class not changed!
  if(myBoard.hasClass(bestChoice))
  {

  }
  else
  {
    myBox.addClass('lock');
    $.each(sizes, function(_cls, _val)
    {
      if(bestChoice == _cls)
      {
      // set best choice
        myBoard.addClass(bestChoice);
        // remove opacity and show it
        setTimeout(function() {
          myBoard.removeClass("op0");
          myBox.removeClass('lock');
        }, 500);
      }
      else
      {
        myBoard.removeClass(_cls);
      }
    });
  }
  console.log(bestChoice);
  // console.log(personCount);
  // console.log(sizes);
}



function refreshAttendance()
{
  if($('body').hasClass('attendance'))
  {
    var myUrl       = window.location.pathname;
    window.location = myUrl;
  }
}


function changeCardStatusOnResult()
{
  $('.attendance form').on('ajaxify:success', function(_e, _result)
  {
    // our request is done successfully
    if(_result.status === 1)
    {
      var myCard = $(this).parents('.tcard');
      // if this request is enter, enable card
      if($(this).hasClass('enter'))
      {
        myCard.attr('data-live', 'on');
        if(_result.msg.now_val)
        {
          myCard.find('.timeEnter').attr('data-val', _result.msg.now_val).text(fitNumber(_result.msg.now, false));
        }
      }
      else if($(this).hasClass('exit'))
      {
        myCard.attr('data-live', 'off');
      }

      unflipAllCards();
    }
    else
    {
      console.log('has error!');
    }
  });
}


/**
 * [reloadAttendance description]
 * @param  {[type]} _force [description]
 * @return {[type]}        [description]
 */
function reloadAttendance(_force)
{

}


/**
 * [runLoadCard description]
 * @return {[type]} [description]
 */
function runLoadCard()
{
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
        flipCard($(this))
      }
    }
  });
}


function flipCard(_card)
{
  if($('body').hasClass('loading-form'))
  {
    console.log('in loading dont allow to show another card...');
    return false;
  }

  unflipAllCards();
  if(_card.attr('data-status') === 'active')
  {
    // add flip to this card
    _card.addClass('flipped');
    calcTotalExit(_card, true);
  }
  else
  {
    console.log('this user is deactive!');
  }
}

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


function bindExtraInput()
{
  $('.tcard form [data-connect]').on('click', function()
  {
    if($('body').hasClass('loading-form'))
    {
      return false;
    }
    var myInput = $(this).parent().find('input');
    var extra   = parseInt($(this).attr('data-val')) || 0;
    // add this value to target
    setExtra(myInput, extra);
  });


  // up and down minus with scrool
  $('.tcard form .parameter').bind('mousewheel', function(e)
  {
    if($('body').hasClass('loading-form'))
    {
      return false;
    }
    var myInput = $(this).find('input[type="number"]');
    if(e.originalEvent.wheelDelta /120 > 0)
    {
      setExtra(myInput, true);
    }
    else{
      setExtra(myInput, false);
    }
  });
}


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
    var setResult = calcTotalExit(_target.parents('.tcard'));
    if(setResult === 0 && _target.hasClass('inputMinus'))
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
    // set currentDate time from dateTime el
    var myDateTime = getDatetime();
    // fill in now
    _card.find('.timeNow').html(fitNumber(myDateTime.html, false));
    // get enter value
    var enter = _card.find('.timeEnter').attr('data-val');
    // calc diff from time of server
    var denter = new Date(enter);
    var dexit  = new Date(myDateTime.val);
    // diff in minute
    var diff   = Math.floor((dexit- denter)/1000/60);
    _card.find('.timeDiff').attr('data-val', diff).text(fitNumber(diff));
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
  var timePure = _card.find('.timePure');
  timePure.attr('data-val', finalTime).text(fitNumber(finalTime));
  if(finalTime === diff)
  {
    timePure.fadeOut('fast');
  }
  else
  {
    timePure.fadeIn();
  }
  return finalTime;
}


/**
 * set link of language on each page
 */
function setLanguageURL()
{
  var urlPath     = window.location.pathname;
  var urlHash     = window.location.hash;
  var indexOfLang = urlPath.indexOf('/' + $('html').attr('lang'));
  var urlBase     = $('base').attr('href');
  urlBase         = urlBase.substr(0, urlBase.indexOf('/', 10));

  if(indexOfLang === 0)
  {
    urlPath = urlPath.substr(4);
  }
  else
  {
    urlPath = urlPath.substr(1);
  }

  $('.langlist a').each(function(key, index)
  {
    var lang = $(index).attr('hreflang');
    // if we are in this language
    if(lang == $('html').attr('lang'))
    {
      $(index).attr('class', 'isActive');
    }
    if(lang == 'en')
    {
      lang = '';
    }
    else if(lang == $('html').attr('lang'))
    {
      // lang = '/' + lang;
    }
    var myUrl = urlPath;
    if(lang)
    {
      myUrl = lang + '/' + myUrl;
    }
    // add hash if exist
    if(urlHash)
    {
      myUrl += urlHash;
    }
    myUrl = urlBase + '/' + myUrl;
    myUrl = myUrl.trim('/');
    myUrl = myUrl.replace(/\/$/, '');

    $(index).attr('href', myUrl);
  })
}



/**
 * [startClock description]
 * @return {[type]} [description]
 */
function startClock()
{
  var myDateTime    = $('#sidebar .dateTime');
  var myDateTimeVal = myDateTime.data('data-val');
  if(!myDateTimeVal)
  {
    myDateTimeVal   = myDateTime.attr('data-val-start');
  }
  var myNow         = new Date(myDateTimeVal);
  myNow             = new Date(myNow.getTime() + 1000);
  myDateTime.data('data-val', myNow);

  // change time
  // var today = new Date();
  changetime(addZero(myNow.getSeconds()), 'second');
  changetime(addZero(myNow.getMinutes()), 'minute');
  changetime(myNow.getHours(), 'hour');
  var t = setTimeout(startClock,1000);

  function addZero(i)
  {
    if (i < 10)
    {
      i = "0" + i
    };
    return i;
  }

  function changetime(_value, _class)
  {
    // if time is not changed, return false
    if($('.time .'+ _class).attr('data-time') == _value)
    {
      return false;
    }
    // set new value with effect
    $('.time .'+ _class).html(fitNumber(_value, false)).attr('data-time', _value);
  }
}


function getDatetime()
{
  var d      = $('#sidebar .dateTime').data('data-val');
  var myVal  = d.getFullYear()+ '-'+ (d.getMonth()+1)+ '-'+ d.getDate()+ ' ' +d.getHours() +':' +d.getMinutes() +':' +d.getSeconds();
  var myHtml = d.getHours() +':' +d.getMinutes();
  return {html:myHtml, val:myVal};
}



function homepageCases()
{
  var myCases       = $('body[data-page="homepage"] #caseStudy [data-case]');
  var currentSlide  = 0;
  var slideInterval = setInterval(nextSlide,10000);

  function nextSlide()
  {
    $(myCases[currentSlide]).removeClass('showing');
    // $(myCases[currentSlide]).fadeOut();
    currentSlide                    = (currentSlide+1)%myCases.length;
    $(myCases[currentSlide]).addClass('showing');
    // $(myCases[currentSlide]).fadeIn();
  }

}




