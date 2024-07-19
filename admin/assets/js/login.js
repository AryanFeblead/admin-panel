$(document).ready(function () {
  $("#val_email,#val_password,#val_role,#success,#notsuccess").hide();

  $("#login_form").on("submit", function (e) {
    e.preventDefault();
    console.log('sfsdg');
    $("#val_email,#val_password,#val_role,#success,#notsuccess").hide();
    var isValid = true;

    var email = $("#emp_email").val();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email == "") {
      $("#val_email").show().css("color", "red");
      isValid = false;
    } else if (!emailPattern.test(email)) {
      $("#val_email").show().css("color", "red").html("Invalid email format");
      isValid = false;
    }

    if ($("#emp_password").val() == "") {
      $("#val_password").show().css("color", "red");
      isValid = false;
    }

   
    if ($(".emp_role:checked").length === 0) {
      $("#val_role").show().css("color", "red");
      isValid = false;
    }
    if (isValid) {
      var formData = new FormData(this);
      formData.append("actionName", "login_user");
      $.ajax({
        type: "POST",
        url: "../assets/php/ajx.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          $("#val_email,#val_password,#val_role,#success,#notsuccess").hide();
          var data1 = JSON.parse(data);
          if (data1.status == "success") {
            $("#login_form")[0].reset();
            // window.location.href = "../../dashboard/";
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
