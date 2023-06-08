<div class="row">
    <div class="col-sm-12">    
        <?=form_open_multipart('rsp/elibrary/save', array('id'=>'formdata'), array('method'=>'edit', 'id_elibrary'=>$elibrary->id_elibrary));?>
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
                                <select required="required" name="kategori" id="kategori" class="select2 form-group" style="width:100% !important">
                                    <option <?= ($elibrary->kategori == 'Kesehatan') ? 'selected' : '' ?> value="Kesehatan">Kesehatan</option>
                                    <option <?= ($elibrary->kategori == 'Umum') ? 'selected' : '' ?> value="Umum">Umum</option>
                                    <option <?= ($elibrary->kategori == 'Bahasa') ? 'selected' : '' ?> value="Bahasa">Bahasa</option>
                                    <option <?= ($elibrary->kategori == 'Sosial') ? 'selected' : '' ?> value="Sosial">Sosial</option>
                                    <option <?= ($elibrary->kategori == 'Lainnya') ? 'selected' : '' ?> value="Lainnya">Lainnya</option>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?=form_error('kategori')?></small>
                            </div>    
                            <div class="form-group">
                                <label for="keterangan" class="control-label">Keterangan</label>
                                <input required="required" value="<?=$elibrary->keterangan?>" type="text" name="keterangan" placeholder="Keterangan" id="keterangan" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('keterangan')?></small>
                            </div>
                            <div class="form-group">
                                <label for="file" class="control-label text-center">File <small>( pdf )</small></label>
                                <input type="file" name="file" id="file" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                                <?php if (!empty($elibrary->file)) : ?> 
                                    <embed src="<?= base_url('uploads/rsp/elibrary/'.$elibrary->file);?>" width="700" height="450"></embed>
                                <?php endif;?> 
                            </div>
                            
                            <div class="form-group pull-right">
                                <a href="<?=base_url('rsp/elibrary')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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