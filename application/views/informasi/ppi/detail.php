<?=form_open('informasi/ppi/verify', array('id'=>'formdata'), array('id_ppi'=>$ppi->id_ppi));?>
<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail Informasi</h3>
        <div class="pull-right">
            <a href="<?=base_url()?>informasi/ppi" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <h3 class="text-center">Kegiatan</h3>
                <strong><?=$ppi->kegiatan?></strong>
                <br>
                <strong>Definisi : </strong><?=$ppi->definisi?>
                
                <hr class="my-4">
                <strong>Dibuat pada : </strong> <?=date($ppi->created_date)?>
                <br>
                <strong>Terkahir diupdate : </strong> <?= ((date($ppi->updated_date))!=null) ? date($ppi->updated_date) : '-'?>
            </div>
            <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Verifikator')) : ?>
            <div class="col-sm-12">
                <div class="form-group pull-right">
                    <input type = "hidden" id = "btn_submit" name = "btn_submit">
                    <?php if ($ppi->publish == 'False'):?>
                        <?php if($ppi->status == 'Denied'): ?>
                            <button type="submit" id="tolak" class="btn btn-flat bg-red" disabled><i class="fa fa-save"></i> Tolak</button>
                            <button type="submit" id="terima" class="btn btn-flat bg-purple" ><i class="fa fa-save"></i> Terima</button>
                        <?php elseif($ppi->status == 'Verified'): ?>
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