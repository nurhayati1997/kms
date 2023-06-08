<div class="row">
    <div class="col-sm-12">    
        <?=form_open_multipart('arsip/save', array('id'=>'formdata'), array('method'=>'edit', 'id_arsip'=>$arsip->id_arsip));?>
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
                                <input required="required" value="<?=$arsip->nama?>" type="text" name="nama" placeholder="Nama File" id="nama" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('nama')?></small>
                            </div>
                            <div class="form-group">
                                <label for="keterangan" class="control-label">Keterangan</label>
                                <input required="required" value="<?=$arsip->keterangan?>" type="text" name="keterangan" placeholder="Keterangan" id="keterangan" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('keterangan')?></small>
                            </div>
                            <div class="form-group">
                                <label for="file" class="control-label text-center">File <small>( pdf )</small></label>
                                <input type="file" name="file" id="file" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                                <?php if (!empty($arsip->file)) : ?>
                                    <embed type="application/pdf" src="<?= base_url('uploads/arsip/'.$arsip->file);?>" width="700" height="450"></embed>
                                <?php endif;?> 
                            </div>
                            
                            <div class="form-group pull-right">
                                <a href="<?=base_url('arsip')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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