<?=form_open_multipart('home/save', array('id'=>'formhome'), array('method'=>'add'));?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Tambah <?=$kategori?></h3>
        <div class="box-tools pull-right">
            <a href="<?=base_url()?>home" class="btn btn-sm btn-flat btn-warning">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?=form_hidden('kategori', $kategori);?>
                <?php if ($kategori == 'IKM'): ?>
                    <div class="col-sm-12">
                        <label for="file" class="control-label">File</label>
                        <div class="form-group">
                            <input required="required" type="file" name="file" class="form-control">
                            <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control summernote"><?=set_value('deskripsi')?></textarea>
                        <small class="help-block" style="color: #dc3545"><?=form_error('deskripsi')?></small>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label for="deskripsi"><?=$kategori?></label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control summernote"><?=set_value('deskripsi')?></textarea>
                        <small class="help-block" style="color: #dc3545"><?=form_error('deskripsi')?></small>
                    </div>
                <?php endif; ?>

                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default reset">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?=form_close();?>

<script>
$(document).ready(function() {
    $(".reset").on("click", function() {
        $('.summernote').summernote('reset');
    })
})
</script>