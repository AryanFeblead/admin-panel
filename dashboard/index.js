$(document).ready(function () {
  $(
    "#dashboard1,#add_event1,#view_event1,#calendar1,#val_name,#val_phone,#val_location,#val_date,#val_time,#val_amount"
  ).hide();
  $("#dashboard").click(function (e) {
    e.preventDefault();
    $("#dashboard1").show();
    $("#add_event1").hide();
    $("#view_event1").hide();
    $("#calendar1").hide();
  });
  $("#add_event").click(function (e) {
    e.preventDefault();
    $("#dashboard1").hide();
    $("#add_event1").show();
    $("#view_event1").hide();
    $("#calendar1").hide();
    $("#event_form").on("submit", function (e) {
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
        formData.append("actionName", "add_user");

        $.ajax({
          type: "POST",
          url: "src/php/ajx.php",
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
  });
  $("#view_event").click(function (e) {
    e.preventDefault();
    $("#dashboard1").hide();
    $("#add_event1").hide();
    $("#view_event1").show();
    $("#calendar1").hide();
  });
  $("#calendar0").click(function (e) {
    e.preventDefault();
    $("#dashboard1").hide();
    $("#add_event1").hide();
    $("#view_event1").hide();
    $("#calendar1").show();
  });
});
