<?=form_open_multipart('rsp/diklat/save', array('id'=>'formdata'), array('method'=>'add'));?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Tambah Diklat</h3>
        <div class="box-tools pull-right">
            <a href="<?=base_url()?>rsp/diklat" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group">
                    <label>Kategori</label>
                        <select name="kategori" required="required" id="kategori" class="select2 form-group" style="width:100% !important">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Seminar">Seminar</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Pelatihan">Pelatihan</option>
                        </select>
                    <small class="help-block" style="color: #dc3545"><?=form_error('kategori')?></small>
                </div>
                <div class="form-group">
                    <label for="keterangan" class="control-label">Keterangan</label>
                    <input required="required" name="keterangan" placeholder="Keterangan" id="keterangan" class="form-control">
                    <small class="help-block" style="color: #dc3545"><?=form_error('keterangan')?></small>
                </div>
                <div class="form-group">
                    <label for="file" class="control-label">File <small>(jpeg | jpg | png | gif)</small></label>
                    <input required="required" type="file" name="file" id="file" class="form-control">
                    <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?=form_close();?>

