<?=form_open_multipart('pelayanan/unggulan/save', array('id'=>'formdata'), array('method'=>'add'));?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Tambah Data</h3>
        <div class="box-tools pull-right">
            <a href="<?=base_url()?>pelayanan/unggulan" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <label for="nama" class="control-label">Nama Pelayanan</label>
                    <input required="required" name="nama" placeholder="Nama Pelayanan Unggulan" id="nama" class="form-control">
                    <small class="help-block" style="color: #dc3545"><?=form_error('nama')?></small>
                </div>
                <div class="form-group">
                    <label for="file" class="control-label">File <small>(jpeg | jpg | png | gif)</small></label>
                    <input required="required" type="file" name="file" id="file" class="form-control">
                    <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                </div>
                <div class="form-group">
                    <label for="keterangan" class="control-label">Keterangan</label>
                    <input required="required" name="keterangan" placeholder="Keterangan" id="keterangan" class="form-control">
                    <small class="help-block" style="color: #dc3545"><?=form_error('keterangan')?></small>
                </div>
                <div class="form-group">
                    <label for="deskripsi" class="control-label">Deskripsi</label>
                    <div class="form-group">
                        <textarea name="deskripsi" id="deskripsi" class="form-control summernote"><?=set_value('deskripsi')?></textarea>
                        <small class="help-block" style="color: #dc3545"><?=form_error('deskripsi')?></small>
                    </div>
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

