<?=form_open_multipart('berita/verify', array('id'=>'formdata'), array('id_berita'=>$berita->id_berita));?>
<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail Informasi</h3>
        <div class="pull-right">
            <a href="<?=base_url()?>berita" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">Informasi Berita</h3>
                <?php if(!empty($berita->file)): ?>
                    <div class="w-100">
                    <?= tampil_media('uploads/berita/'.$berita->file); ?>
                    </div>
                <?php endif; ?>

                <strong>Nama Berita : </strong><?=$berita->nama?>
                <br>
                <strong>Keterangan : </strong><?=$berita->keterangan?>                

                <hr class="my-4">
                <strong>Dibuat pada : </strong> <?=date($berita->created_date)?>
                <br>
                <strong>Terkahir diupdate : </strong> <?= ((date($berita->updated_date))!=null) ? date($berita->updated_date) : '-'?>
            </div>
            </div>
            <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Verifikator')) : ?>
            <div class="col-sm-12">
                <div class="form-group pull-right">
                    <input type = "hidden" id = "btn_submit" name = "btn_submit">
                    <?php if ($berita->publish == 'False'):?>
                        <?php if($berita->status == 'Denied'): ?>
                            <button type="submit" id="tolak" class="btn btn-flat bg-red" disabled><i class="fa fa-save"></i> Tolak</button>
                            <button type="submit" id="terima" class="btn btn-flat bg-purple" ><i class="fa fa-save"></i> Terima</button>
                        <?php elseif($berita->status == 'Verified'): ?>
                            <button type="submit" id="tolak" class="btn btn-flat bg-red" ><i class="fa fa-save"></i> Tolak</button>
                            <button type="submit" id="terima" class="btn btn-flat bg-purple" disabled><i class="fa fa-save"></i> Terima</button>
                        <?php else: ?>
                            <button type="submit" id="tolak" class="btn btn-flat bg-red" ><i class="fa fa-save"></i> Tolak</button>
                            <button type="submit" id="terima" class="btn btn-flat bg-purple" ><i class="fa fa-save"></i> Terima</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button type="submit" id="tolak" class="btn btn-flat bg-red" disabled><i class="fa fa-save"></i> Tolak</button>
                        <button type="submit" id="terima" class="btn btn-flat bg-purple" disabled><i class="fa fa-save"></i> Terima</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?=form_close();?>

<script type="text/javascript">
$(document).ready(function(){
    $(document).on("click", "#tolak", function(event){
        $('#btn_submit').val('Denied');
    });

    $(document).on("click", "#terima", function(event){
        $('#btn_submit').val('Verified');
    });
});
</script>