$(document).ready(function()
{
  onOpenModal();
  detectBarcode();
  scheduleCheck();
  changeCardStatusOnResult();
  bindExtraInput();

});



function onOpenModal()
{
  $('#setTraffic').on('open', function()
  {
    var $myModal  = $(this);
    var myUser    = $myModal.attr('data-user');
    var $userCard = $('#showMember .vcard[data-user='+ myUser +']');

    // set user id
    $myModal.find('[name=user]').val(myUser);
    // set user photo and name from main card detail
    $myModal.find('.vcard img').attr('src', $userCard.find('img').attr('src'));
    $myModal.find('.vcard .header').text($userCard.find('.header').text());
    $myModal.find('.vcard .meta').text($userCard.find('.meta').text());


  });
}


function detectBarcode()
{
  $("body").on("barcode:detect", function(_e, _code)
  {
    _code        = _code.toString();
    var $rfid    = $('#showMember .vcard[data-rfid="'+ _code +'"]');
    var myUser     = null;
    // rfid
    if($rfid.length)
    {
      myUser = $rfid.attr('data-user');
    }
    // barcode
    var $barcode = $('#showMember .vcard[data-barcode="'+ _code +'"]');
    if($barcode.length)
    {
      myUser = $barcode.attr('data-user');
    }
    // qrcode
    var $qrcode  = $('#showMember .vcard[data-qrcode="'+ _code +'"]');
    if($qrcode.length)
    {
      myUser = $qrcode.attr('data-user');
    }

    openCard(myUser);
    console.log(myUser);
  });
}


// open card if needed and some other things!
function openCard(_id)
{
  var $userCard = $('#showMember .vcard[data-user='+ _id +']');
  var $modal    = $('#setTraffic');
  if($modal.hasClass('visible'))
  {
    if($modal.attr('data-user') == _id)
    {
      // press btn of form, enter or exit
      if($modal.attr('data-live') === 'off')
      {
        $modal.find('form.enter button').click();
      }
      else if($modal.attr('data-live') === 'on')
      {
        $modal.find('form.exit button').click();
      }
      else
      {
        console.log('How are you!');
      }
    }
    else
    {
      // open card of this user
      $userCard.click();
    }
  }
  else
  {
    // only open the card
    $userCard.click();
  }
}


function scheduleCheck()
{
  var slideInterval = setInterval(nextSlide,10000);
  function nextSlide()
  {

  }

}


function changeCardStatusOnResult()
{
  $('.attendance form').on('ajaxify:success', function(_e, _result)
  {
    // our request is done successfully
    if(_result.status === 1)
    {
      var myUser    = $(this).find('input[name="user"]').val();
      var $userCard = $('#showMember .vcard[data-user='+ myUser +']');


      // if this request is enter, enable card
      if($(this).hasClass('enter'))
      {
        $userCard.attr('data-live', 'on');
        $userCard.data('live', 'on');
        if(_result.msg.now_val)
        {
          $userCard.attr('data-enter', _result.msg.now_val);
        }
      }
      else if($(this).hasClass('exit'))
      {
        $userCard.attr('data-live', 'off');
        $userCard.data('live', 'off');
      }
    }
    else
    {
      console.log('has error!');
    }
  });
}



function bindExtraInput()
{
  $('#setTraffic form [data-connect]').on('click', function()
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
  $('#setTraffic form [data-allowminus], #setTraffic form [data-allowplus]').bind('mousewheel', function(e)
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
    var setResult = calcTotalExit(_target.parents('#setTraffic'));
    if(setResult === 0 && _target.hasClass('inputMinus'))
    {
      setExtraInvalid(_target);
    }
  }

  /**
   * [setExtraInvalid description]
   * @param {[type]} _target [description]
   */
  function setExtraInvalid(_target)
  {
    $(_target).addClass('error');
    setTimeout(function()
    {
      $(_target).removeClass('error');
    }, 300);
  }
}



