// on start
route('*', function ()
{

}).once(function()
{


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

    runLoadCard();

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
  var myBoxHeight = Math.floor(myBox.height() * 0.9);
  var myBoxWidth  = Math.floor(myBox.width() * 0.85);
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
    var canShow = Math.floor( (myBoxDim/_val)*0.85 );
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




