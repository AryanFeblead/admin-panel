$(document).ready(function () {
  $(
    "#success,#notsuccess,#dashboard1,#add_event1,#view_event1,#calendar1,#val_name,#val_phone,#val_location,#val_date,#val_date1,#val_time,#val_amount"
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
          success: function (data) {
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
          error: function () {
            $("#event_form")[0].reset();
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

    $.ajax({
      type: "POST",
      url: "src/php/ajx.php",
      data: {
        actionName: "view_event",
      },
      success: function (data) {
        data1 = $.parseJSON(data);
        console.log(data1);
        var rows = "";
        $.each(data1, function (index, user) {
          rows += "<tr>";
          rows += "<td>" + user.eve_id + "</td>";
          rows += "<td>" + user.eve_name + "</td>";
          rows += "<td>" + user.eve_location + "</td>";
          rows += "<td>" + user.eve_to_date + "</td>";
          rows += "<td>" + user.eve_from_date + "</td>";
          rows += "<td>" + user.eve_time + "</td>";
          rows += "<td>" + user.eve_amount + "</td>";
          rows +=
            '<td><a data-id="' +
            user.emp_id +
            '" class="btn btn-primary text-white edit">Edit</a></td>';
          rows +=
            '<td><a data-id="' +
            user.emp_id +
            '" class="btn btn-danger text-white delete">Delete</a></td>';
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
              url: "src/php/ajx.php",
              data: {
                id: id,
                actionName: "eve_delete",
              },
              success: function (response) {
                var data = $.parseJSON(response);
                if (data.status === "success") {
                  $("#success").show().delay(2000).fadeOut();
                  $("#success").html("Event Deleted Successfully");
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
  $("#calendar0").click(function (e) {
    e.preventDefault();
    $("#dashboard1").hide();
    $("#add_event1").hide();
    $("#view_event1").hide();
    $("#calendar1").show();
  });
});
