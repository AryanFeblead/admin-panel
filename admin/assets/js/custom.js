$(document).ready(function() {
    $('#success,#notsuccess,#create_user1,#view_user1,#val_name,#val_email,#val_phone,#val_password,#val_role,#val_permission').hide();
    $('#create_user').click(function(e) {
        e.preventDefault();
        $('#create_user1').show();
        $('#view_user1').hide();
        $('#create_user_form').on('submit', function(e) {
            e.preventDefault();
            if ($('#emp_name').val() == '') {
                $('#val_name').show().css('color', 'red');
            }
            if ($('#emp_email').val() == '') {
                $('#val_email').show().css('color', 'red');
            }
            if ($('#emp_phone').val() == '') {
                $('#val_phone').show().css('color', 'red');
            }
            if ($('#emp_password').val() == '') {
                $('#val_password').show().css('color', 'red');
            }
            if ($('.emp_role:checked').val() == undefined) {
                $('#val_role').show().css('color', 'red');
            }
            if ($('.emp_event:checked').val() == undefined) {
                $('#val_permission').show().css('color', 'red');
            }
            if ($('.emp_calendar:checked').val() == undefined) {
                $('#val_permission').show().css('color', 'red');
            }
            if ($('.emp_dashboard:checked').val() == undefined) {
                $('#val_permission').show().css('color', 'red');
            } else {
                var formData = new FormData(this);
                formData.append('actionName', 'add_user');
                $.ajax({
                    type: "POST",
                    url: "assets/php/ajx.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log('done');
                        console.log(data);
                        var data1 = JSON.parse(data);
                        if (data1.status == 'success') {
                            $('#val_name,#val_email,#val_phone,#val_password,#val_role,#val_permission').hide();
                            $("#create_user_form")[0].reset();
                            $('#success').show().delay(2000).fadeOut().html("Employee Added Successfully");
                        }
                    },
                    error: function() {
                        $("#prod_form")[0].reset();
                        $('#notsuccess').show().html('Product Added Failed');
                    }
                });
            }
        });
    });
    $('#view_user').click(function(e) {
        e.preventDefault();
        $('#view_user1').show();
        $('#create_user1').hide();
        $.ajax({
            type: "POST",
            url: "assets/php/ajx.php",
            data: {
                actionName: 'view_user'
            },
            success: function(data) {
                data1 = $.parseJSON(data);
                console.log(data1);
                var rows = '';
                $.each(data1, function(index, user) {
                    rows += '<tr>';
                    rows += '<td>' + user.emp_id + '</td>';
                    rows += '<td>' + user.emp_name + '</td>';
                    rows += '<td>' + user.emp_email + '</td>';
                    rows += '<td>' + user.emp_phone + '</td>';
                    rows += '<td>' + user.emp_role + '</td>';
                    rows += '<td>' + user.emp_event + '</td>';
                    rows += '<td>' + user.emp_calendar + '</td>';
                    rows += '<td>' + user.emp_dashboard + '</td>';
                    rows += '<td><a data-id="' + user.emp_id + '" class="btn btn-primary edit">Edit</a></td>';
                    rows += '<td><a data-id="' + user.emp_id + '" class="btn btn-danger delete">Delete</a></td>';
                    rows += '</tr>';
                });

                $('#result').html(rows);
                $('#emp_tbl').DataTable();

                $('.edit').on('click', function() {
                    var id = $(this).data('id');
                    fetchData(id);
                    $(document).on('click', '#btn_update', function() {
                        updateData(id);
                    })
                });

                $('.delete').on('click', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    if (confirm("Are you sure?")) {
                        $.ajax({
                            type: "POST",
                            url: "assets/php/ajx.php",
                            data: {
                                id: id,
                                actionName: 'prod_delete'
                            },
                            success: function(response) {
                                var data = $.parseJSON(response);
                                if (data.status === "success") {
                                    $('#success').show().delay(2000).fadeOut();
                                    $('#success').html("Product Deleted Successfully");
                                    window.location.reload();
                                }
                            },
                            error: function(status, error) {
                                console.error("AJAX Error: " + status + error);
                            }
                        });
                    } else {
                        return false;
                    }
                })
            },
            error: function(status, error) {
                console.error("Fetch Error: " + status + error);
            }
        });

    });
});