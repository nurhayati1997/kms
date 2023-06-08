<?=form_open_multipart('home/save', array('id'=>'formhome'), array('method'=>'edit', 'id_home'=>$home->id_home));?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Edit <?=$home->kategori?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?=form_hidden('kategori', $home->kategori);?>

                <?php if ($home->kategori == 'IKM') : ?>
                    <div class="form-group">
                        <input type="file" name="file" class="form-control">
                        <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                        <?php if (!empty($home->file)) : ?>
                            <?=tampil_media('uploads/home/'.$home->file);?>
                        <?php endif;?>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control summernote"><?= $home->deskripsi ?></textarea>
                        <small class="help-block" style="color: #dc3545"><?=form_error('deskripsi')?></small>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label for="deskripsi"><?=$home->kategori?></label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control summernote"><?= $home->deskripsi ?></textarea>
                        <small class="help-block" style="color: #dc3545"><?=form_error('deskripsi')?></small>
                    </div>
                <?php endif; ?>   
                
                <div class="form-group pull-right">
                    <a href="<?=base_url('home')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?=form_close();?>