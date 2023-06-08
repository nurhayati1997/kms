<div class="row">
    <div class="col-sm-12">    
        <?=form_open_multipart('pelayanan/ranap/save', array('id'=>'formdata'), array('method'=>'edit', 'id_pelayanan_ranap'=>$data->id_pelayanan_ranap));?>
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
                                <label for="ruang" class="control-label">Ruangan</label>
                                <select required="required" name="ruang" id="ruang" class="select2 form-group" style="width:100% !important">
                                    <option value="" disabled selected>Pilih Ruangan</option>
                                    <?php
                                    $id_ruangan = $data->id_ruangan;
                                    foreach ($ruang as $d) :
                                        $id_kelas = $d->id_kelas?>
                                        <option <?=$id_ruangan===$id_kelas?"selected":"";?> value="<?=$id_kelas?>"><?=$d->nama_kelas?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?=form_error('ruang')?></small>
                            </div>
                            <div class="form-group">
                                <label for="file" class="control-label text-center">File <small>(jpeg | jpg | png | gif)</small></label>
                                <input type="file" name="file" id="file" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                                <?php if (!empty($data->file)) : ?>
                                    <?=tampil_media('uploads/pelyanan/ranap/'.$data->file);?>
                                <?php endif;?> 
                            </div>
                            <div class="form-group pull-right">
                                <a href="<?=base_url('pelayanan/ranap')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
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