$(document).ready(function() {
    $(
        "#success,#notsuccess,#dashboard1,#add_event1,#view_event1,#calendar1,#val_name,#val_phone,#val_location,#val_date,#val_date1,#val_time,#val_amount"
    ).hide();
    $("#dashboard").click(function(e) {
        e.preventDefault();
        $("#dashboard1").show();
        $("#add_event1").hide();
        $("#view_event1").hide();
        $("#calendar1").hide();
    });
    $("#add_event").click(function(e) {
        e.preventDefault();
        $("#dashboard1").hide();
        $("#add_event1").show();
        $("#view_event1").hide();
        $("#calendar1").hide();
        $("#event_form").on("submit", function(e) {
            e.preventDefault();

            var isValid = true;
            $("#val_name,#val_phone,#val_location,#val_time,#val_amount").hide();

            if ($("#eve_name").val() == "") {
                $("#val_name").show().css("color", "red");
                isValid = false;
            }

            if ($("#eve_location").val() == "") {
                $("#val_location").show().css("color", "red");
                isValid = false;
            }
            if ($("#eve_date").val() == "") {
                $("#val_date").show().css("color", "red");
                isValid = false;
            }
            if ($("#eve_date1").val() == "") {
                $("#val_date1").show().css("color", "red");
                isValid = false;
            }
            if ($("#eve_time").val() == "") {
                $("#val_time").show().css("color", "red");
                isValid = false;
            }

            if ($("#eve_amount").val() == "") {
                $("#val_amount").show().css("color", "red");
                isValid = false;
            }

            if (isValid) {
                var formData = new FormData(this);
                formData.append("actionName", "add_event");

                $.ajax({
                    type: "POST",
                    url: "src/php/ajx.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log("done");
                        console.log(data);
                        var data1 = JSON.parse(data);
                        if (data1.status == "success") {
                            $(
                                "#val_name,#val_phone,#val_location,#val_time,#val_amount"
                            ).hide();
                            $("#event_form")[0].reset();
                            $("#success")
                                .show()
                                .delay(2000)
                                .fadeOut()
                                .html("Event Added Successfully");
                        }
                    },
                    error: function() {
                        $("#event_form")[0].reset();
                        $("#notsuccess").show().html("Employee Addition Failed");
                    },
                });
            }
        });
    });
    $("#view_event").click(function(e) {
        e.preventDefault();
        $("#dashboard1").hide();
        $("#add_event1").hide();
        $("#view_event1").show();
        $("#calendar1").hide();

        $.ajax({
            type: "POST",
            url: "src/php/ajx.php",
            data: {
                actionName: "view_event",
            },
            success: function(data) {
                data1 = $.parseJSON(data);

                $(".edit").on("click", function() {
                    console.log('sdfsdgdf');
                    var id = $(this).data("id");
                    fetchData(id);
                    $(document).on("click", "#btn_update", function() {
                        updateData(id);
                    });
                });

                $(".delete").on("click", function(e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    if (confirm("Are you sure?")) {
                        $.ajax({
                            type: "POST",
                            url: "src/php/ajx.php",
                            data: {
                                id: id,
                                actionName: "eve_delete",
                            },
                            success: function(response) {
                                var data = $.parseJSON(response);
                                if (data.status === "success") {
                                    $("#success").show().delay(2000).fadeOut();
                                    $("#success").html("Event Deleted Successfully");
                                    window.location.reload();
                                }
                            },
                            error: function(status, error) {
                                console.error("AJAX Error: " + status + error);
                            },
                        });
                    } else {
                        return false;
                    }
                });
            },
            error: function(status, error) {
                console.error("Fetch Error: " + status + error);
            },
        });
    });
    $("#calendar0").click(function(e) {
        e.preventDefault();
        $("#dashboard1").hide();
        $("#add_event1").hide();
        $("#view_event1").hide();
        $("#calendar1").show();
    });

    function fetchData(id) {
        $.ajax({
            url: "src/php/ajx.php",
            method: "post",
            data: {
                id: id,
                actionName: "eve_fetch",
            },
            dataType: "JSON",
            success: function(data) {
                $("#eve_name1").val(data[0])
                $("#eve_location1").val(data[1])
                $("#eve_date1").val(data[2])
                $("#eve_date11").val(data[3])
                $("#eve_time1").val(data[4])
                $("#eve_amount1").val(data[5])
                $("#Update").modal("show");
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            },
        });
    }

    function updateData(id) {
        var isValid = true;

        $(
            "#val_name1, #val_email1, #val_phone1, #val_password1, #val_role1, #val_permission1"
        ).hide();

        // Validate employee name
        if ($("#emp_name1").val() == "") {
            $("#val_name1").show().css("color", "red");
            isValid = false;
        }

        // Validate email
        var email = $("#emp_email1").val();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email == "") {
            $("#val_email1").show().css("color", "red");
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#val_email1").show().css("color", "red").html("Invalid email format");
            isValid = false;
        }

        // Validate phone number
        var phone = $("#emp_phone1").val();
        if (phone == "") {
            $("#val_phone1").show().css("color", "red");
            isValid = false;
        } else if (phone.length < 10) {
            $("#val_phone1")
                .show()
                .html("Mobile no. should be 10 digits")
                .css("color", "red");
            isValid = false;
        }

        // Validate password
        if ($("#emp_password1").val() == "") {
            $("#val_password1").show().css("color", "red");
            isValid = false;
        }

        // Validate role
        if ($(".emp_role:checked").length === 0) {
            $("#val_role").show().css("color", "red");
            isValid = false;
        }

        // Validate permissions
        if (
            $(".emp_event:checked").length === 0 ||
            $(".emp_calendar:checked").length === 0 ||
            $(".emp_dashboard:checked").length === 0
        ) {
            $("#val_permission").show().css("color", "red");
            isValid = false;
        }
        if (isValid) {
            //   var prod_name1 = $("#prod_name1").val();
            //   var prod_qun1 = $("#prod_qun1").val();
            //   var prod_price1 = $("#prod_price1").val();
            //   var prod_detail1 = $("#prod_address1").val();
            //   var prod_img1 = $("#prod_img1").val();
            //   console.log($("#prod_img1").val());
            var formData = new FormData(this);
            //   formData.append("prod_id", id);
            //   formData.append("prod_name1", prod_name1);
            //   formData.append("prod_img1", prod_img1);
            //   formData.append("prod_qun1", prod_qun1);
            //   formData.append("prod_price1", prod_price1);
            //   formData.append("prod_detail1", prod_detail1);
            formData.append("actionName", "update");
            $.ajax({
                url: "assets/php/ajx.php",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $(
                        "#val_name1, #val_email1, #val_phone1, #val_password1, #val_role1, #val_permission1"
                    ).hide();
                    $("#Update").modal("hide");
                    $(".alert-success")
                        .show()
                        .fadeOut(function() {
                            // window.location.reload()
                        });
                    $(".alert-success").html("Data Updated Successfully");
                    $(".alert-success").hide();
                },
                error: function() {
                    $(".alert-danger").show().delay(2000).fadeOut();
                    $(".alert-danger").html("Data not Updated!!!");
                    $(".alert-danger").hide();
                },
            });
        }
    }
});