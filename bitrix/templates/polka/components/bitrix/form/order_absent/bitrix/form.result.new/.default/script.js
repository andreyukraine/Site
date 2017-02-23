$(document).ready(function()
{
    //$(document).on('.btn-primary', 'click', function()
    $('.btn-primary').click(function()
    {
        console.log('/==========');

        $tThis = this;
        //formSerialize = $(this).closest('form').submit();
        formSerialize2 = $(this).closest('form').serialize();
        $.ajax({
                   type: "POST",
                   url: location.href, //"/test/",
                   data: formSerialize2,
                   dataType: 'html'
               })
         .done(function( msg )
               {
                   $($tThis).closest('form').prepend('как только товар поступит в продажу Вам сообщат');
                   console.log(msg);
               });

        return false;
    });
    console.log('/==========');
});
console.log('/==========');