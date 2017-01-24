/**
 * Created by keke- on 24/01/2017.
 */

$('a.delete_link').on('click', function(event)
{
    event.preventDefault();
    $('div.modal a.btn-primary').attr('href', $(this).attr('href'));
    $('div.modal').modal();
});
