<div class="row">
    <div class="col-sm-12">    
        <?=form_open_multipart('pelayanan/save', array('id'=>'formpelayanan'), array('method'=>'add'));?>
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
                        <div class="form-group col-sm-12">
                            <label>Jenis Pelayanan</label>
                            <select name="jenis" required="required" id="jenis" class="select2 form-group" style="width:100% !important">
                                <option value="" disabled selected>Pilih Jenis Pelayanan</option>
                                <option value="unggulan">Unggulan</option>
                                <option value="igd">Gawat Darurat</option>
                                <option value="rajal">Rawat Jalan</option>
                                <option value="ranap">Rawat Inap</option>
                                <option value="penunjang">Penunjang</option>
                            </select>
                            <small class="help-block" style="color: #dc3545"><?=form_error('jenis')?></small>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Ruangan</label>
                            <select name="ruang" required="required" id="ruang" class="select2 form-group" style="width:100% !important">
                                <option value="" disabled selected>Pilih Ruangan</option>
                                <?php foreach ($ruang as $d) : ?>
                                    <option value="<?=$d->id_kelas?>"><?=$d->nama_kelas?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="help-block" style="color: #dc3545"><?=form_error('jenis')?></small>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="pelayanan" class="control-label">Pelayanan</label>
                            <input required="required" name="pelayanan" placeholder="Nama Pelayanan" id="pelayanan" class="form-control">
                            <small class="help-block" style="color: #dc3545"><?=form_error('pelayanan')?></small>
                        </div>
                        <div class="col-sm-12">
                            <label for="file" class="control-label">File  <small>(jpeg | jpg | png | gif)</small></label>
                            <div class="form-group">
                                <input required="required" type="file" name="file" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?=form_error('file')?></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="deskripsi" class="control-label">Deskripsi</label>
                            <div class="form-group">
                                <textarea name="deskripsi" id="deskripsi" class="form-control summernote"><?=set_value('deskripsi')?></textarea>
                                <small class="help-block" style="color: #dc3545"><?=form_error('deskripsi')?></small>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <a href="<?=base_url('pelayanan')?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Batal</a>
                            <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Simpan</button>
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
            $('#ruang').attr('disabled', 'disabled');
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
        }else if ($('#jenis').val() == 'penunjang') {
            $('#ruang').removeAttr('disabled');
            $('#deskripsi').attr('disabled', 'disabled');
            $('#deskripsi').summernote('destroy');
        }else{
            $('#ruang').attr('disabled', 'disabled');
            $('#deskripsi').attr('disabled', 'disabled');
            $('#deskripsi').summernote('destroy');
        }
    })

});
</script>