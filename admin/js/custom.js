$(document).ready(function(){

    var loader_div = "<div id='load-screen'><div id='loading'></div></div>";

    $('body').prepend(loader_div);

    $('#load-screen').delay(500).fadeOut(500, function() {
        $(this).remove();
    });

    tinymce.init({
        selector: 'textarea'
    });

    $('#select_all').on('change', function(){

        $("input:checkbox").prop('checked', $(this).prop("checked"));

    });

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

    $(document).on('click', '#delete_post' ,function(e) {

        var id = $(this).data("id");

        alertify.confirm("Confirm", "Do you want to delete this post?",
        function(){
            window.location.href = "posts.php?delete=" + id;
        },
        function(){
        }).set('labels', {ok:'Yes', cancel:'No'});

    });

    $(document).on('click', '#reset_views' ,function(e) {

        var id = $(this).data("id");

        alertify.confirm("Confirm", "Do you want to reset views for this post?",
        function(){
            window.location.href = "posts.php?reset_views=" + id;
        },
        function(){
        }).set('labels', {ok:'Yes', cancel:'No'});

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
        error: function(err){
            alert("Error " + err.statusText);
        }
    });

});

function loadUsersOnline() {

    $.ajax({
        type : 'get',
        url : 'includes/functions.php?online_users=result',
        success : function(data){
            $('#online_users').html(data);
        }
    });

}

setInterval(function() {
    loadUsersOnline();
}, 500);
