banyak = Number(banyak);
$(document).ready(function () {
    if (banyak < 1 || banyak > 50) {
        alert('Maksimum input 50');
        window.location.href = base_url+"poli";
    } else {
        generate(banyak);
    }

    $('#inputs input:first').select();
    $('form#poli input').on('change', function () {
        $(this).parent('.form-group').removeClass('has-error');
        $(this).next('.help-block').text('');
    });

    $('form#poli').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var btn = $('#submit');
        btn.attr('disabled', 'disabled').text('Wait...');

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            method: 'POST',
            success: function (data) {
                btn.removeAttr('disabled').text('Simpan');
                //console.log(data);
                if (data.status) {
                    Swal({
                        "title": "Sukses",
                        "text": "Data Berhasil disimpan",
                        "type": "success"
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = base_url+'poli';
                        }
                    });
                } else {
                    var j;
                    for (let i = 0; i <= data.errors.length; i++) {
                        $.each(data.errors[i], function (key, val) {
                            j = $('[name="' + key + '"]');
                            j.parent().addClass('has-error');
                            j.next('.help-block').text(val);
                            if (val == '') {
                                j.parent('.form-group').removeClass('has-error');
                                j.next('.help-block').text('');
                            }
                        });
                    }
                }
            }
        });
    });
});

function generate(n) {
    for (let i = 1; i <= n; i++) {
        inputs = `
            <tr>
                <td>${i}</td>
                <td>
                    <div class="form-group">
                        <input autocomplete="off" type="text" name="nama_poli[${i}]" class="input-sm form-control">
                        <input type="hidden" name="kelas_id[${i}]" value="7">
                        <small class="help-block text-right"></small>
                    </div>
                </td>
            </tr>
            `;
        $('#inputs').append(inputs);
    }
}