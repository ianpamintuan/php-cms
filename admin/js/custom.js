$(document).ready(function(){

    $('.category_row').on('click', function (e) {
        var row_id = $(this).data('id');
        $.ajax({
            type : 'post',
            url : 'includes/fetch_record.php', //Here you will fetch records 
            data :  'row_id='+ row_id, //Pass $id
            success : function(data){
                $('.fetched-data').html(data);//Show fetched data from database
            },
            error: function(){
                alert("Error");
            }
        });
    });

});

$(document).on('click', '#editSave', function (e) {
    $.ajax({
        type : 'post',
        url : 'includes/save.php',
        data :  $('form.editForm').serialize(),
        success : function(data){
            $('#message').html(data);
            $('#editModal').modal('hide');
        },
        error: function(){
            alert("Error");
        }
    });

});
