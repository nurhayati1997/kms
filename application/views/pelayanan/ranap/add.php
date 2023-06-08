<?=form_open_multipart('pelayanan/ranap/save', array('id'=>'formdata'), array('method'=>'add'));?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Tambah Data</h3>
        <div class="box-tools pull-right">
            <a href="<?=base_url()?>pelayanan/ranap" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <label for="ruang">Ruangan</label>
                    <select name="ruang" required="required" id="ruang" class="select2 form-group" style="width:100% !important">
                        <option value="" disabled selected>Pilih Ruangan</option>
                        <?php foreach ($ruang as $d) : ?>
                            <option value="<?=$d->id_kelas?>"><?=$d->nama_kelas?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block" style="color: #dc3545"><?=form_error('ruang')?></small>
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

