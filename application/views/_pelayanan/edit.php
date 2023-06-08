<div class="row">
    <div class="col-sm-12">    
        <?=form_open_multipart('pelayanan/save', array('id'=>'formpelayanan'), array('method'=>'edit', 'id_pelayanan'=>$pelayanan->id_pelayanan));?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$subjudul?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="dosen_id" class="control-label">Jenis Pelayanan</label>
                                <?php //if ($this->ion_auth->is_admin()) : ?>
                                <select required="required" name="jenis" id="jenis" class="select2 form-group" style="width:100% !important">
                                    <option <?= ($pelayanan->jenis == 'unggulan') ? 'selected' : '' ?> value="unggulan">Unggulan</option>
                                    <option <?= ($pelayanan->jenis == 'igd') ? 'selected' : '' ?> value="igd">Gawat Darurat</option>
                                    <option <?= ($pelayanan->jenis == 'rajal') ? 'selected' : '' ?> value="rajal">Rawat Jalan</option>
                                    <option <?= ($pelayanan->jenis == 'ranap') ? 'selected' : '' ?> value="ranap">Rawat Inap</option>
                                    <option <?= ($pelayanan->jenis == 'penunjang') ? 'selected' : '' ?> value="penunjang">Penunjang</option>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?=form_error('jenis')?></small>
                                <?php //else : ?>
                                <!--<input type="hidden" name="dosen_id" value="<?//=$dosen->id_dosen;?>">
                                <input type="hidden" name="matkul_id" value="<?//=$dosen->matkul_id;?>">
                                <input type="text" readonly="readonly" class="form-control" value="<?//=$dosen->nama_dosen; ?> (<?=$dosen->nama_matkul; ?>)">-->
                                <?php //endif; ?>
                            </div>
                            
                            <div class="form-group col-sm-12">
                                <label for="pelayanan" class="control-label">Nama Pelayanan</label>
                                <input required="required" value="<?=$pelayanan->pelayanan?>" type="text" name="pelayanan" placeholder="Nama Pelayanan" id="pelayanan" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('pelayanan')?></small>
                            </div>

                            <div class="col-sm-12">
                                <label for="soal" class="control-label text-center">File <small>(jpeg | jpg | png | gif)</small></label>
                                <div class="form-group">
                                    <input type="file" name="file" class="form-control">
                                    <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                                    <?php if (!empty($pelayanan->file)) : ?>
                                        <?=tampil_media('uploads/bank_soal/'.$pelayanan->file);?>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="soal" class="control-label text-center">Deskripsi</label>
                                <div class="form-group">
                                    <?php if ($pelayanan->jenis != 'unggulan') : ?>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" disabled><?=$pelayanan->deskripsi?></textarea>
                                    <?php else : ?>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control summernote"><?=$pelayanan->deskripsi?></textarea>
                                    <?php endif;?>
                                    <small class="help-block" style="color: #dc3545"><?=form_error('deskripsi')?></small>
                                </div>   
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?=base_url('pelayanan')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?=form_close();?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#jenis").change(function(){
        if ($('#jenis').val() == 'unggulan'){
            $('#deskripsi').attr('disabled', 'disabled');
            $('#deskripsi').summernote('destroy');
            //alert ('oke');
        }else{
            $('#deskripsi').removeAttr("disabled");
            $('.summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });
        }
    })
});
</script>