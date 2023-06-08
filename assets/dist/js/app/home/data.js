var tablevisi;
var tablemisi;
var tablemaklumat;
var tablemotto;
var tableslogan;
var tablejanji;
var tableikm;

$(document).ready(function() {
  ajaxcsrf();

  // Visi
  tablevisi = $("#Visi").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#Visi_filter input")
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
      url: base_url + "home/data",
      data:{"kategori":"Visi"},
      type: "POST"
    },
    columns: [
      {
        data: "id_home",
        orderable: false,
        searchable: false
      },
      { data: "deskripsi" },
      { data: "created_date" },
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
        data: {id_home :"id_home", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Visi')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Visi')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}home/edit/${data.id_home}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_home",
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

  tablevisi
    .buttons()
    .container()
    .appendTo("#Visi_wrapper .col-md-6:eq(0)");

  $(".select_all_visi").on("click", function() {
    if (this.checked) {
      $("#Visi .check").each(function() {
        this.checked = true;
        $(".select_all_visi").prop("checked", true);
      });
    } else {
      $("#Visi .check").each(function() {
        this.checked = false;
        $(".select_all_visi").prop("checked", false);
      });
    }
  });

  $("#Visi tbody").on("click", "tr .check", function() {
    var check = $("#Visi tbody tr .check").length;
    var checked = $("#Visi tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all_visi").prop("checked", true);
    } else {
      $(".select_all_visi").prop("checked", false);
    }
  });

  $("#bulk_Visi").on("submit", function(e) {
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
        reload('Visi');
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

  // Misi
  tablemisi = $("#Misi").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#Misi_filter input")
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
      url: base_url + "home/data",
      data:{"kategori":"Misi"},
      type: "POST"
    },
    columns: [
      {
        data: "id_home",
        orderable: false,
        searchable: false
      },
      { data: "deskripsi" },
      { data: "created_date" },
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
        data: {id_home :"id_home", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Misi')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Misi')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}home/edit/${data.id_home}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_home",
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

  tablemisi
    .buttons()
    .container()
    .appendTo("#Misi_wrapper .col-md-6:eq(0)");

  $(".select_all_misi").on("click", function() {
    if (this.checked) {
      $("#Misi .check").each(function() {
        this.checked = true;
        $(".select_all_misi").prop("checked", true);
      });
    } else {
      $("#Misi .check").each(function() {
        this.checked = false;
        $(".select_all_misi").prop("checked", false);
      });
    }
  });

  $("#Misi tbody").on("click", "tr .check", function() {
    var check = $("#Misi tbody tr .check").length;
    var checked = $("#Misi tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all_misi").prop("checked", true);
    } else {
      $(".select_all_misi").prop("checked", false);
    }
  });

  $("#bulk_Misi").on("submit", function(e) {
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
        reload('Misi');
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

  // Maklumat
  tablemaklumat = $("#Maklumat").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#Maklumat_filter input")
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
      url: base_url + "home/data",
      data:{"kategori":"Maklumat"},
      type: "POST"
    },
    columns: [
      {
        data: "id_home",
        orderable: false,
        searchable: false
      },
      { data: "deskripsi" },
      { data: "created_date" },
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
        data: {id_home :"id_home", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Maklumat')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Maklumat')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}home/edit/${data.id_home}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_home",
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

  tablemaklumat
    .buttons()
    .container()
    .appendTo("#Maklumat_wrapper .col-md-6:eq(0)");

  $(".select_all_maklumat").on("click", function() {
    if (this.checked) {
      $("#Maklumat .check").each(function() {
        this.checked = true;
        $(".select_all_maklumat").prop("checked", true);
      });
    } else {
      $("#Maklumat .check").each(function() {
        this.checked = false;
        $(".select_all_maklumat").prop("checked", false);
      });
    }
  });

  $("#Maklumat tbody").on("click", "tr .check", function() {
    var check = $("#Maklumat tbody tr .check").length;
    var checked = $("#Maklumat tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all_maklumat").prop("checked", true);
    } else {
      $(".select_all_maklumat").prop("checked", false);
    }
  });

  $("#bulk_Maklumat").on("submit", function(e) {
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
        reload('Maklumat');
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

  // Motto
  tablemotto= $("#Motto").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#Motto_filter input")
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
      url: base_url + "home/data",
      data:{"kategori":"Motto"},
      type: "POST"
    },
    columns: [
      {
        data: "id_home",
        orderable: false,
        searchable: false
      },
      { data: "deskripsi" },
      { data: "created_date" },
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
        data: {id_home :"id_home", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Motto')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Motto')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}home/edit/${data.id_home}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_home",
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

  tablemotto
    .buttons()
    .container()
    .appendTo("#Motto_wrapper .col-md-6:eq(0)");

  $(".select_all_motto").on("click", function() {
    if (this.checked) {
      $("#Motto .check").each(function() {
        this.checked = true;
        $(".select_all_motto").prop("checked", true);
      });
    } else {
      $("#Motto .check").each(function() {
        this.checked = false;
        $(".select_all_motto").prop("checked", false);
      });
    }
  });

  $("#Motto tbody").on("click", "tr .check", function() {
    var check = $("#Motto tbody tr .check").length;
    var checked = $("#Motto tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all_motto").prop("checked", true);
    } else {
      $(".select_all_motto").prop("checked", false);
    }
  });

  $("#bulk_Motto").on("submit", function(e) {
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
        reload('Motto');
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

  // Slogan
  tableslogan = $("#Slogan").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#Slogan_filter input")
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
      url: base_url + "home/data",
      data:{"kategori":"Slogan"},
      type: "POST"
    },
    columns: [
      {
        data: "id_home",
        orderable: false,
        searchable: false
      },
      { data: "deskripsi" },
      { data: "created_date" },
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
        data: {id_home :"id_home", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Slogan')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Slogan')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}home/edit/${data.id_home}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_home",
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

  tableslogan
    .buttons()
    .container()
    .appendTo("#Slogan_wrapper .col-md-6:eq(0)");

  $(".select_all_slogan").on("click", function() {
    if (this.checked) {
      $("#Slogan .check").each(function() {
        this.checked = true;
        $(".select_all_slogan").prop("checked", true);
      });
    } else {
      $("#Slogan .check").each(function() {
        this.checked = false;
        $(".select_all_slogan").prop("checked", false);
      });
    }
  });

  $("#Slogan tbody").on("click", "tr .check", function() {
    var check = $("#Slogan tbody tr .check").length;
    var checked = $("#Slogan tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all_slogan").prop("checked", true);
    } else {
      $(".select_all_slogan").prop("checked", false);
    }
  });

  $("#bulk_Slogan").on("submit", function(e) {
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
        reload('Slogan');
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

  // Janji
  tablejanji= $("#Janji").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#Janji_filter input")
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
      url: base_url + "home/data",
      data:{"kategori":"Janji"},
      type: "POST"
    },
    columns: [
      {
        data: "id_home",
        orderable: false,
        searchable: false
      },
      { data: "deskripsi" },
      { data: "created_date" },
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
        data: {id_home :"id_home", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Janji')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Janji')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}home/edit/${data.id_home}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_home",
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

  tablejanji
    .buttons()
    .container()
    .appendTo("#Janji_wrapper .col-md-6:eq(0)");

  $(".select_all_janji").on("click", function() {
    if (this.checked) {
      $("#Janji .check").each(function() {
        this.checked = true;
        $(".select_all_janji").prop("checked", true);
      });
    } else {
      $("#Janji .check").each(function() {
        this.checked = false;
        $(".select_all_janji").prop("checked", false);
      });
    }
  });

  $("#Janji tbody").on("click", "tr .check", function() {
    var check = $("#Janji tbody tr .check").length;
    var checked = $("#Janji tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all_janji").prop("checked", true);
    } else {
      $(".select_all_janji").prop("checked", false);
    }
  });

  $("#bulk_Janji").on("submit", function(e) {
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
        reload('Janji');
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

  // IKM
  tableikm = $("#IKM").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#IKM_filter input")
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
      url: base_url + "home/data",
      data:{"kategori":"IKM"},
      type: "POST"
    },
    columns: [
      {
        data: "id_home",
        orderable: false,
        searchable: false
      },
      { data: "deskripsi" },
      { data: "created_date" },
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
        data: {id_home :"id_home", status:"status", publish: "publish"},
        render: function(data, type, row, meta) {
          let btn;
          if (data.publish === 'True') {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Misi')">
								<i class="fa fa-link"></i>
							</button>`;
          } else {
            btn = `<button type="button" class="btn btn-aktif btn-primary btn-xs" onclick="publish(${data.id_home},'Misi')">
								<i class="fa fa-unlink"></i>
							</button>`;
          }

          if (data.status === 'Verified') {
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                                ${btn}
                            </div>`;
          } else if (data.status === 'Denied'){
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-xs btn-warning" disabled>
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          } else{
            return `<div class="text-center">
                                <a href="${base_url}home/detail/${data.id_home}" class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="${base_url}home/edit/${data.id_home}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>`;
          }
        }
      },
      {
        targets: 5,
        data: "id_home",
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

  tableikm
    .buttons()
    .container()
    .appendTo("#IKM_wrapper .col-md-6:eq(0)");

  $(".select_all_ikm").on("click", function() {
    if (this.checked) {
      $("#IKM .check").each(function() {
        this.checked = true;
        $(".select_all_ikm").prop("checked", true);
      });
    } else {
      $("#IKM .check").each(function() {
        this.checked = false;
        $(".select_all_ikm").prop("checked", false);
      });
    }
  });

  $("#IKM tbody").on("click", "tr .check", function() {
    var check = $("#IKM tbody tr .check").length;
    var checked = $("#IKM tbody tr .check:checked").length;
    if (check === checked) {
      $(".select_all_ikm").prop("checked", true);
    } else {
      $(".select_all_ikm").prop("checked", false);
    }
  });

  $("#bulk_IKM").on("submit", function(e) {
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
        reload('IKM');
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

function reload($kategori) {
  $('#'+$kategori).DataTable().ajax.reload();
}

function publish($id,$kategori) {
  Swal({
      title: "Anda yakin?",
      text: "Konten akan ditampilkan atau ditarik",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yakin!"
  }).then(result => {
      if (result.value) {
          $.getJSON(base_url + "home/publish/" + $id, function(data) {
              Swal({
                  title: data.status ? "Berhasil" : "Gagal",
                  text: data.status
                      ? "Konten berhasil ditampilkan atau ditarik"
                      : "Konten gagal ditampilkan atau ditarik",
                  type: data.status ? "success" : "error"
              });
              reload($kategori);
          });
      }
  });
}

function bulk_delete($kategori) {
  if ($("#"+$kategori+" tbody tr .check:checked").length == 0) {
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
        $("#bulk_"+$kategori).submit();
      }
    });
  }
}
