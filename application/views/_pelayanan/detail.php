<?=form_open_multipart('pelayanan/verify', array('id'=>'formverifikasi'), array('id_pelayanan'=>$pelayanan->id_pelayanan));?>
<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail Konten</h3>
        <div class="pull-right">
            <a href="<?=base_url()?>pelayanan" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <!--<a href="<?=base_url()?>pelayanan/edit/<?=$this->uri->segment(3)?>" class="btn btn-xs btn-flat btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>-->
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">Pelayanan</h3>
                <?php if(!empty($pelayanan->file)): ?>
                    <div class="w-50">
                        <?= tampil_media('uploads/bank_soal/'.$pelayanan->file); ?>
                    </div>
                <?php endif; ?>
                <strong>Nama Pelayanan : </strong><?=$pelayanan->pelayanan?>
                <br>
                <strong>Jenis Pelayanan : </strong><?=$pelayanan->jenis?>
                <br>
                <strong>Deskripsi : </strong><?=$pelayanan->deskripsi?>
                
                <hr class="my-4">
                <strong>Dibuat pada : </strong> <?=date($pelayanan->created_date)?>
                <br>
                <strong>Terkahir diupdate : </strong> <?=date($pelayanan->updated_date)?>
            </div>
            <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Verifikator')) : ?>
            <div class="col-sm-12">
                <div class="form-group pull-right">
                    <input type = "hidden" id = "btn_submit" name = "btn_submit">
                    <?php if($pelayanan->status == 'False'): ?>
                        <button type="submit" id="tolak" class="btn btn-flat bg-red" disabled><i class="fa fa-save"></i> Tolak</button>
                        <button type="submit" id="terima" class="btn btn-flat bg-purple" ><i class="fa fa-save"></i> Terima</button>
                    <?php elseif($pelayanan->status == 'True'): ?>
                        <button type="submit" id="tolak" class="btn btn-flat bg-red" ><i class="fa fa-save"></i> Tolak</button>
                        <button type="submit" id="terima" class="btn btn-flat bg-purple" disabled><i class="fa fa-save"></i> Terima</button>
                    <?php else: ?>
                        <button type="submit" id="tolak" class="btn btn-flat bg-red" ><i class="fa fa-save"></i> Tolak</button>
                        <button type="submit" id="terima" class="btn btn-flat bg-purple" ><i class="fa fa-save"></i> Terima</button>
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
        $('#btn_submit').val('False');
    });

    $(document).on("click", "#terima", function(event){
        $('#btn_submit').val('True');
    });
});
</script>