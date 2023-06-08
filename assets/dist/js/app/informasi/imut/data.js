var table

$(document).ready(function() {
  ajaxcsrf();

  table = $("#imut").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#imut_filter input")
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
        exportOptions: { columns: [1, 2, 3, 4] }
      },
      {
        extend: "print",
        exportOptions: { columns: [1, 2, 3, 4] }
      },
      {
        extend: "excel",
        exportOptions: { columns: [1, 2, 3, 4] }
      },
      {
        extend: "pdf",
        exportOptions: { columns: [1, 2, 3, 4] }
      }
    ],
    oLanguage: {
      sProcessing: "loading..."
    },
    processing: true,
    serverSide: true,
    ajax: {
      url: base_url + "informasi/imut/data",
      type: "POST"
    },
    columns: [
      {
        data: "id_imut",
        orderable: false,
        searchable: false
      },
      { data: "nama" },
      { data: "file" },
      { data: "status" }
    ],
    columnDefs: [
      {
        targets: 3,
        data: "status",
        render: function(data, type, row, meta) {
          if (data === "Verified") {
            return `<div class="text-center">
                    <span class="badge bg-green">Verified</span>
                </div>`;
          } else if (data === "Denied") {
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
        searchable: false,
        targets: 4,
        data: {id_imut :"id_imut", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_imut},'Misi')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_imut},'Misi')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}informasi/imut/detail/${data.id_imut}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}informasi/imut/detail/${data.id_imut}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}informasi/imut/detail/${data.id_imut}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}informasi/imut/edit/${data.id_imut}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_imut",
        render: function(data, type, row, meta) {
          return `<div class="text-center">
									<input name="checked[]" class="check" value="${data}" type="checkbox">
								</div>`;
        }
      }
    ],
    order: [[1, "asc"]],
    rowId: function(a) {
      return a;
    },
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $("td:eq(0)", row).html(index);
    }
  });

  table
    .buttons()
    .container()
    .appendTo("#imut_wrapper .col-md-6:eq(0)");

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

  $("#imut tbody").on("click", "tr .check", function() {
    var check = $("#imut tbody tr .check").length;
    var checked = $("#imut tbody tr .check:checked").length;
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

function publish($id) {
  Swal({
      title: "Anda yakin?",
      text: "Informasi akan ditampilkan atau ditarik",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yakin!"
  }).then(result => {
      if (result.value) {
          $.getJSON(base_url + "informasi/imut/publish/" + $id, function(data) {
              Swal({
                  title: data.status ? "Berhasil" : "Gagal",
                  text: data.status
                      ? "Informasi berhasil ditampilkan atau ditarik"
                      : "Informasi gagal ditampilkan atau ditarik",
                  type: data.status ? "success" : "error"
              });
              reload_ajax();
          });
      }
  });
}

function bulk_delete() {
  if ($("#imut tbody tr .check:checked").length == 0) {
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
