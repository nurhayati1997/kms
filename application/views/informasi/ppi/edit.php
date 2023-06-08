<?=form_open('informasi/ppi/save', array('id'=>'formdata'), array('method'=>'edit', 'id_ppi'=>$ppi->id_ppi));?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Edit PPI</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group">
                    <label for="kegiatan">Kegiatan</label>
                    <input value="<?=$ppi->kegiatan?>" type="text" class="form-control" name="kegiatan" placeholder="Kegiatan">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="definisi" class="control-label text-center">Deskripsi</label>
                    <textarea name="definisi" id="definisi" class="form-control summernote"><?=$ppi->definisi?></textarea>
                    <small class="help-block" style="color: #dc3545"><?=form_error('definisi')?></small>  
                </div>
                <div class="form-group pull-right">
                    <a href="<?=base_url('informasi/ppi')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?=form_close();?>

<script src="<?=base_url()?>assets/dist/js/app/informasi/ppi/edit.js"></script>