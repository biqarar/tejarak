$(document).ready(function()
{
  onOpenModal();
});



function onOpenModal()
{
  $('#setTraffic').on('open', function()
  {
    $myModal = $(this);
    console.log('modal is opened!');
    console.log($myModal);

    $myModal.find('[name=user]').val($myModal.attr('data-user'));

  });
}

