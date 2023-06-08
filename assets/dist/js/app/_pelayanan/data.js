var table;

$(document).ready(function() {
  ajaxcsrf();

  table = $("#soal").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#jenis_filter input")
        .off(".DT")
        .on("keyup.DT", function(e) {
          api.search(this.value).draw();
        });
    },
    dom:
      "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: "copy",
        exportOptions: { columns: [2, 3, 4, 5] }
      },
      {
        extend: "print",
        exportOptions: { columns: [2, 3, 4, 5] }
      },
      {
        extend: "excel",
        exportOptions: { columns: [2, 3, 4, 5] }
      },
      {
        extend: "pdf",
        exportOptions: { columns: [2, 3, 4, 5] }
      }
    ],
    oLanguage: {
      sProcessing: "loading..."
    },
    processing: true,
    serverSide: true,
    ajax: {
      url: base_url + "pelayanan/data",
      type: "POST"
    },
    columns: [
      {
        data: "id_pelayanan",
        orderable: false,
        searchable: false
      },
      {
        data: "id_pelayanan",
        orderable: false,
        searchable: false
      },
      { data: "pelayanan" },
      { data: "file" },
      { data: "jenis" },
      { data: "updated_date" },
      { data: "status" }
    ],
    columnDefs: [
      {
        targets: 0,
        data: "id_pelayanan",
        render: function(data, type, row, meta) {
          return `<div class="text-center">
									<input name="checked[]" class="check" value="${data}" type="checkbox">
								</div>`;
        }
      },
      {
        targets: 6,
        data: "status",
        render: function(data, type, row, meta) {
          if (data === "True") {
            return `<div class="text-center">
                    <span class="badge bg-green">Verified</span>
                </div>`;
          } else if (data === "False") {
            return `<div class="text-center">
                    <span class="badge bg-red">Denied</span>
                </div>`;
          } else {
            return `<div class="text-center">
                    <span class="badge">Process</span>
                </div>`;
          }
        }
      },
      {
        targets: 7,
        data: {id_pelayanan :"id_pelayanan", status:"status"},
        render: function(data, type, row, meta) {
          if (data.status === null) {
            return `<div class="text-center">
                                <a href="${base_url}pelayanan/detail/${data.id_pelayanan}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="${base_url}pelayanan/edit/${data.id_pelayanan}" class="btn btn-xs btn-warning" >
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </div>`;
          } else {
            return `<div class="text-center">
                                <a href="${base_url}pelayanan/detail/${data.id_pelayanan}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="${base_url}pelayanan/edit/${data.id_pelayanan}" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </div>`;
          }
        }
      }
    ],
    order: [[4, "desc"]],
    rowId: function(a) {
      return a;
    },
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $("td:eq(1)", row).html(index);
    }
  });

  table
    .buttons()
    .container()
    .appendTo("#soal_wrapper .col-md-6:eq(0)");

  $(".select_all").on("click", function() {
    if (this.checked) {
      $(".check").each(function() {
        this.checked = true;
        $(".select_all").prop("checked", true);
      });
    } else {
      $(".check").each(function() {
        this.checked = false;
        $(".select_all").prop("checked", false);
      });
    }
  });

  $("#soal tbody").on("click", "tr .check", function() {
    var check = $("#soal tbody tr .check").length;
    var checked = $("#soal tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all").prop("checked", true);
    } else {
      $(".select_all").prop("checked", false);
    }
  });

  $("#bulk").on("submit", function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    $.ajax({
      url: $(this).attr("action"),
      data: $(this).serialize(),
      type: "POST",
      success: function(respon) {
        if (respon.status) {
          Swal({
            title: "Berhasil",
            text: respon.total + " data berhasil dihapus",
            type: "success"
          });
        } else {
          Swal({
            title: "Gagal",
            text: "Tidak ada data yang dipilih",
            type: "error"
          });
        }
        reload_ajax();
      },
      error: function() {
        Swal({
          title: "Gagal",
          text: "Ada data yang sedang digunakan",
          type: "error"
        });
      }
    });
  });
});

function bulk_delete() {
  if ($("#soal tbody tr .check:checked").length == 0) {
    Swal({
      title: "Gagal",
      text: "Tidak ada data yang dipilih",
      type: "error"
    });
  } else {
    Swal({
      title: "Anda yakin?",
      text: "Data akan dihapus!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Hapus!"
    }).then(result => {
      if (result.value) {
        $("#bulk").submit();
      }
    });
  }
}
