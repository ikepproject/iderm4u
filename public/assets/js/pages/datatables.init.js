/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Datatables Js File
*/

$(document).ready(function () {
  //Patient Table
  var table_patient = $("#datatable-patient").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
      [25, 70, 100, -1],
      [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
  });

  table_patient
    .buttons()
    .container()
    .appendTo("#datatable-patient_wrapper .col-md-6:eq(0)");

  $(".dataTables_length select").addClass("form-select form-select-sm");
});
