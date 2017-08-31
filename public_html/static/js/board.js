$(document).ready(function()
{
  onOpenModal();
});



function onOpenModal()
{
  $('#setTraffic').on('open', function()
  {
    var $myModal  = $(this);
    var user     = $myModal.attr('data-user');
    var $userCard = $('#showMember .vcard[data-user='+ user +']');

    // set user id
    $myModal.find('[name=user]').val(user);
    // set user photo and name

    $myModal.find('.vcard img').attr('src', $userCard.find('img').attr('src'));
    $myModal.find('.vcard .header').text($userCard.find('.header').text());
    $myModal.find('.vcard .meta').text($userCard.find('.meta').text());

  });
}

