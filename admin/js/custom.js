$(document).ready(function(){

    tinymce.init({
        selector: 'textarea',
        theme: 'modern',
        plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        image_advtab: true,
        templates: [
          { title: 'Test template 1', content: 'Test 1' },
          { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'
        ]
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
