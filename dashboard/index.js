$(document).ready(function() {
    $(
        "#success,#notsuccess,#dashboard1,#add_event1,#view_event1,#calendar1,#val_name,#val_phone,#val_location,#val_date,#val_date1,#val_time,#val_amount,#val_name1,#val_phone1,#val_location1,#val_date12,#val_date11,#val_time1,#val_amount1"
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
                $("#eve_date12").val(data[2])
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
            "#val_name1,#val_phone1,#val_location1,#val_date12,#val_date11,#val_time1,#val_amount1"
        ).hide();

        if ($("#eve_name1").val() == "") {
            $("#val_name1").show().css("color", "red");
            isValid = false;
        }

        if ($("#eve_location1").val() == "") {
            $("#val_location1").show().css("color", "red");
            isValid = false;
        }
        if ($("#eve_date12").val() == "") {
            $("#val_date12").show().css("color", "red");
            isValid = false;
        }
        if ($("#eve_date11").val() == "") {
            $("#val_date11").show().css("color", "red");
            isValid = false;
        }
        if ($("#eve_time1").val() == "") {
            $("#val_time1").show().css("color", "red");
            isValid = false;
        }

        if ($("#eve_amount1").val() == "") {
            $("#val_amount1").show().css("color", "red");
            isValid = false;
        }

        if (isValid) {
            var eve_name1 = $("#eve_name1").val();
            var eve_location1 = $("#eve_location1").val();
            var eve_date12 = $("#eve_date12").val();
            var eve_date11 = $("#eve_date11").val();
            var eve_time1 = $("#eve_time1").val();
            var eve_amount1 = $("#eve_amount1").val();
            var formData = new FormData();
            formData.append("id", id);
            formData.append("eve_name1", eve_name1);
            formData.append("eve_location1", eve_location1);
            formData.append("eve_date12", eve_date12);
            formData.append("eve_date11", eve_date11);
            formData.append("eve_time1", eve_time1);
            formData.append("eve_amount1", eve_amount1);
            formData.append("actionName", "eve_update");
            $.ajax({
                url: "src/php/ajx.php",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $(
                        "#val_name1,#val_phone1,#val_location1,#val_date12,#val_date11,#val_time1,#val_amount1"
                    ).hide();
                    $("#Update").modal("hide");
                    window.location.reload()
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