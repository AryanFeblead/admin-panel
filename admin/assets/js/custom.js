$(document).ready(function() {
    $('#create_user1').hide();
    $('#view_user1').hide();
    $('#create_user').click(function(e) {
        e.preventDefault();
        $('#create_user1').show();
        $('#view_user1').hide();
        $('#add_user').on('submit', function(e) {
            e.preventDefault();
            $('#emp_name').val()
            $('#emp_email').val()
            $('#emp_phone').val()
            $('#emp_password').val()
            $('#emp_role').val()
            $('#emp_event').val()
            $('#emp_calander').val()
            $('#emp_dashboard').val()

            var formData = new FormData(this);
            formData.append('actionName', 'add_product');
            $.ajax({
                type: "POST",
                url: "assets/php/ajx.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log('done');
                    var data1 = JSON.parse(data);
                    if (data1.status == 'success') {
                        $('#prod_nameval,#prod_imgval,#prod_qunval,#prod_priceval,#prod_detailval').hide()
                        $("#prod_form")[0].reset();
                        $('#success').show().delay(2000).fadeOut().html("Product Added Successfully");
                    }
                },
                error: function() {
                    $("#prod_form")[0].reset();
                    $('#notsuccess').show().html('Product Added Failed')
                }
            });
        })
    });
    $('#view_user').click(function(e) {
        e.preventDefault();
        $('#create_user1').hide();
        $('#view_user1').show();
        // $('#add_user').on('submit', function(e) {
        //     e.preventDefault();
        //     var formData = new FormData(this);
        //     formData.append('actionName', 'add_product');
        //     $.ajax({
        //         type: "POST",
        //         url: "assets/php/ajx.php",
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         success: function(data) {
        //             console.log('done');
        //             var data1 = JSON.parse(data);
        //             if (data1.status == 'success') {
        //                 $('#prod_nameval,#prod_imgval,#prod_qunval,#prod_priceval,#prod_detailval').hide()
        //                 $("#prod_form")[0].reset();
        //                 $('#success').show().delay(2000).fadeOut().html("Product Added Successfully");
        //             }
        //         },
        //         error: function() {
        //             $("#prod_form")[0].reset();
        //             $('#notsuccess').show().html('Product Added Failed')
        //         }
        //     });
        // })
    });
});