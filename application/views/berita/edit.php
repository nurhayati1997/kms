<div class="row">
    <div class="col-sm-12">    
        <?=form_open_multipart('berita/save', array('id'=>'formdata'), array('method'=>'edit', 'id_berita'=>$berita->id_berita));?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Edit</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="row">
                            <div class="form-group">
                                <label for="nama" class="control-label">Nama</label>
                                <input required="required" value="<?=$berita->nama?>" type="text" name="nama" placeholder="Nama Berita" id="nama" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('nama')?></small>
                            </div>
                            <div class="form-group">
                                <label for="keterangan" class="control-label text-center">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control summernote"><?=$berita->keterangan?></textarea>
                                <small class="help-block" style="color: #dc3545"><?=form_error('keterangan')?></small>  
                            </div>
                            <div class="form-group">
                                <label for="file" class="control-label text-center">File <small>(jpeg | jpg | png | gif)</small></label>
                                <input type="file" name="file" id="file" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                                <?php if (!empty($berita->file)) : ?>
                                    <?= tampil_media('uploads/berita/'.$berita->file); ?>
                                <?php endif;?> 
                            </div>
                            <div class="form-group pull-right">
                                <a href="<?=base_url('berita')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                                <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?=form_close();?>
    </div>
</div>