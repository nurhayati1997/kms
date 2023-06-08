<div class="row">
    <div class="col-sm-12">    
        <?=form_open_multipart('informasi/dokter/save', array('id'=>'formdokter'), array('method'=>'edit', 'id_dokter'=>$dokter->id_dokter));?>
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
                    <div class="col-sm-4 col-sm-offset-4">
                        <div class="row">
                            <div class="form-group">
                                <label for="ruang" class="control-label">Jenis Pelayanan</label>
                                <select required="required" multiple="multiple" name="ruang[]" id="ruang[]" class="select2 form-group" style="width:100% !important">
                                    <?php
                                    $a = explode("|",$dokter->id_poli);
                                    $array = [];
                                    foreach ($a as $key => $val) {
                                        $array[] = $val;
                                    }
                                    
                                    foreach ($ruang as $d) :?>
                                        <option <?=in_array($d->id_poli, $array) ? "selected" : "" ;?> value="<?=$d->id_poli?>"><?=$d->nama_poli?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?=form_error('ruang')?></small>
                            </div>
                            
                            <div class="form-group">
                                <label for="nama" class="control-label">Nama</label>
                                <input required="required" value="<?=$dokter->nama?>" type="text" name="nama" placeholder="Nama Dokter" id="nama" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('nama')?></small>
                            </div>

                            <div class="form-group">
                                <label for="file" class="control-label text-center">File <small>(jpeg | jpg | png | gif)</small></label>
                                <input type="file" name="file" id="file" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                                <?php if (!empty($dokter->file)) : ?>
                                    <?=tampil_media('uploads/informasi/dokter/'.$dokter->file);?>
                                <?php endif;?> 
                            </div>
                            
                            <div class="form-group pull-right">
                                <a href="<?=base_url('informasi/dokter')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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