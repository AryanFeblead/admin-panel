$(document).ready(function () {
  $(
    "#success,#notsuccess,#create_user1,#view_user1,#val_name,#val_email,#val_phone,#val_password,#val_role,#val_permission,#val_name1,#val_email1,#val_phone1,#val_password1,#val_role1,#val_permission1"
  ).hide();
  $("#emp_phone,#emp_phone1").on("input", function () {
    if ($(this).val().length > 10) {
      $(this).val($(this).val().substring(0, 10));
    }
  });

  $("#create_user").click(function (e) {
    e.preventDefault();
    $("#create_user1").show();
    $("#view_user1").hide();
  });

  $("#create_user_form").on("submit", function (e) {
    e.preventDefault();

    // Reset isValid to true at the beginning of validation
    var isValid = true;

    // Hide all validation messages initially
    $(
      "#val_name, #val_email, #val_phone, #val_password, #val_role, #val_permission"
    ).hide();

    // Validate employee name
    if ($("#emp_name").val() == "") {
      $("#val_name").show().css("color", "red");
      isValid = false;
    }

    // Validate email
    var email = $("#emp_email").val();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email == "") {
      $("#val_email").show().css("color", "red");
      isValid = false;
    } else if (!emailPattern.test(email)) {
      $("#val_email").show().css("color", "red").html("Invalid email format");
      isValid = false;
    }

    // Validate phone number
    var phone = $("#emp_phone").val();
    if (phone == "") {
      $("#val_phone").show().css("color", "red");
      isValid = false;
    } else if (phone.length < 10) {
      $("#val_phone")
        .show()
        .html("Mobile no. should be 10 digits")
        .css("color", "red");
      isValid = false;
    }

    // Validate password
    if ($("#emp_password").val() == "") {
      $("#val_password").show().css("color", "red");
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

    // Proceed with AJAX submission if form is valid
    if (isValid) {
      var formData = new FormData(this);
      formData.append("actionName", "add_user");

      $.ajax({
        type: "POST",
        url: "assets/php/ajx.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          console.log("done");
          console.log(data);
          var data1 = JSON.parse(data);
          if (data1.status == "success") {
            $(
              "#val_name, #val_email, #val_phone, #val_password, #val_role, #val_permission"
            ).hide();
            $("#create_user_form")[0].reset();
            $("#success")
              .show()
              .delay(2000)
              .fadeOut()
              .html("Employee Added Successfully");
          }
        },
        error: function () {
          $("#create_user_form")[0].reset();
          $("#notsuccess").show().html("Employee Addition Failed");
        },
      });
    }
  });
  $("#view_user").click(function (e) {
    e.preventDefault();
    $("#view_user1").show();
    $("#create_user1").hide();
    $.ajax({
      type: "POST",
      url: "assets/php/ajx.php",
      data: {
        actionName: "view_user",
      },
      success: function (data) {
        data1 = $.parseJSON(data);
        console.log(data1);
        var rows = "";
        $.each(data1, function (index, user) {
          rows += "<tr>";
          rows += "<td>" + user.emp_id + "</td>";
          rows += "<td>" + user.emp_name + "</td>";
          rows += "<td>" + user.emp_email + "</td>";
          rows += "<td>" + user.emp_phone + "</td>";
          rows += "<td>" + user.emp_role + "</td>";
          rows += "<td>" + user.emp_event + "</td>";
          rows += "<td>" + user.emp_calendar + "</td>";
          rows += "<td>" + user.emp_dashboard + "</td>";
          rows +=
            '<td><a data-id="' +
            user.emp_id +
            '" class="btn btn-primary edit">Edit</a></td>';
          rows +=
            '<td><a data-id="' +
            user.emp_id +
            '" class="btn btn-danger delete">Delete</a></td>';
          rows += "</tr>";
        });

        $("#result").html(rows);
        $("#emp_tbl").DataTable();

        $(".edit").on("click", function () {
          var id = $(this).data("id");
          fetchData(id);
          $(document).on("click", "#btn_update", function () {
            updateData(id);
          });
        });

        $(".delete").on("click", function (e) {
          e.preventDefault();
          var id = $(this).data("id");
          if (confirm("Are you sure?")) {
            $.ajax({
              type: "POST",
              url: "assets/php/ajx.php",
              data: {
                id: id,
                actionName: "emp_delete",
              },
              success: function (response) {
                var data = $.parseJSON(response);
                if (data.status === "success") {
                  $("#success").show().delay(2000).fadeOut();
                  $("#success").html("Employee Deleted Successfully");
                  window.location.reload();
                }
              },
              error: function (status, error) {
                console.error("AJAX Error: " + status + error);
              },
            });
          } else {
            return false;
          }
        });
      },
      error: function (status, error) {
        console.error("Fetch Error: " + status + error);
      },
    });
  });

  function fetchData(id) {
    console.log(id);
    $("#Update").modal("show");
    $.ajax({
      url: "assets/php/ajx.php",
      method: "post",
      data: {
        id: id,
        actionName: "fetch",
      },
      dataType: "JSON",
      success: function (data) {
        $("#emp_name1").val(data[0]);
        $("#emp_email1").val(data[1]);
        $("#emp_phone1").val(data[2]);
        $("#emp_password1").val(data[3]);
        $("input[name='emp_role1'][value='" + data[4] + "']").prop(
          "checked",
          true
        );
        $("input[name='emp_event1'][value='" + data[5] + "']").prop(
          "checked",
          true
        );
        $("input[name='emp_calendar1'][value='" + data[6] + "']").prop(
          "checked",
          true
        );
        $("input[name='emp_dashboard1'][value='" + data[7] + "']").prop(
          "checked",
          true
        );

        $("#Update").modal("show");
      },
      error: function (xhr) {
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
        success: function (data) {
          $(
            "#val_name1, #val_email1, #val_phone1, #val_password1, #val_role1, #val_permission1"
          ).hide();
          $("#Update").modal("hide");
          $(".alert-success")
            .show()
            .fadeOut(function () {
              // window.location.reload()
            });
          $(".alert-success").html("Data Updated Successfully");
          $(".alert-success").hide();
        },
        error: function () {
          $(".alert-danger").show().delay(2000).fadeOut();
          $(".alert-danger").html("Data not Updated!!!");
          $(".alert-danger").hide();
        },
      });
    }
  }
});
