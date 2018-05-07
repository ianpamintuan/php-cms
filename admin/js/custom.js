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

    $('.delete_post').on('click', function (e) {
        
        e.preventDefault();
        
        var post_id = $(this).data('id');

        alertify.confirm("Confirm", "Do you want to delete this post?",
        function(){

            $.ajax({
                type : 'post',
                url : 'includes/delete_post.php',
                data :  'post_id='+ post_id,
                success : function(data){
                   location.reload();
                },
                error: function(){
                    alert("Error");
                }
            });
 
        },
        function(){
        }).set('labels', {ok:'Yes', cancel:'No'});
 
    });

    $('.delete_user').on('click', function (e) {
        
        e.preventDefault();
        
        var user_id = $(this).data('id');

        alertify.confirm("Confirm", "Do you want to delete this user?",
        function(){

            $.ajax({
                type : 'post',
                url : 'includes/delete_user.php',
                data :  'user_id='+ user_id,
                success : function(data){
                   location.reload();
                },
                error: function(){
                    alert("Error");
                }
            });
 
        },
        function(){
        }).set('labels', {ok:'Yes', cancel:'No'});
 
    });

    $('.delete_category').on('click', function (e) {
        
        e.preventDefault();
        
        var category_id = $(this).data('id');

        alertify.confirm("Confirm", "Do you want to delete this category?",
        function(){

            $.ajax({
                type : 'post',
                url : 'includes/delete_category.php',
                data :  'category_id='+ category_id,
                success : function(data){
                   location.reload();
                },
                error: function(){
                    alert("Error");
                }
            });
 
        },
        function(){
        }).set('labels', {ok:'Yes', cancel:'No'});
 
    });

    $('.delete_comment').on('click', function (e) {
        
        e.preventDefault();
        
        var comment_id = $(this).data('id');

        alertify.confirm("Confirm", "Do you want to delete this comment?",
        function(){

            $.ajax({
                type : 'post',
                url : 'includes/delete_comment.php',
                data :  'comment_id='+ comment_id,
                success : function(data){
                   location.reload();
                },
                error: function(){
                    alert("Error");
                }
            });
 
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
            
            $('#editModal').modal('hide');
            location.reload();
            $('#message').html(data);
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
