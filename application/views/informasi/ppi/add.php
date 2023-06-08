<?=form_open('informasi/ppi/save', array('id'=>'formdata'), array('method'=>'add'));?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Tambah Data</h3>
        <div class="box-tools pull-right">
            <a href="<?=base_url()?>informasi/ppi" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group">
                    <label for="kegiatan" class="control-label">Kegiatan</label>
                    <input required="required" name="kegiatan" placeholder="Kegiatan" id="kegiatan" class="form-control">
                    <small class="help-block" style="color: #dc3545"><?=form_error('kegiatan')?></small>
                </div>
                <div class="form-group">
                    <label for="definisi">Definisi</label>
                    <textarea name="definisi" id="definisi" class="form-control summernote"><?=set_value('definisi')?></textarea>
                    <small class="help-block" style="color: #dc3545"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?=form_close();?>

<script src="<?=base_url()?>assets/dist/js/app/informasi/ppi/add.js"></script>
