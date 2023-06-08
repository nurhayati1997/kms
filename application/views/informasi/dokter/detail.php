<?=form_open_multipart('informasi/dokter/verify', array('id'=>'formdokter'), array('id_dokter'=>$dokter->id_dokter));?>
<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail Informasi</h3>
        <div class="pull-right">
            <a href="<?=base_url()?>informasi/dokter" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <h3 class="text-center">Informasi Dokter</h3>
                <?php if(!empty($dokter->file)): ?>
                    <div class="w-100">
                        <?= tampil_media('uploads/informasi/dokter/'.$dokter->file); ?>
                    </div>
                <?php endif; ?>
                <strong>Nama Dokter : </strong><?=$dokter->nama?>
                <br>
                <strong>Ruangan : </strong>
                <br>
                <?php
                $poli = explode("|",$dokter->id_poli);
                $no =1;
                foreach ($poli as $key => $val) {
                    foreach ($ruang as $d){
                        if ($val == $d->id_poli){
                            echo $no.". ";
                            echo "$d->nama_poli";
                            echo "<br>";
                        }
                    }
                $no++;
                }
                ?>

                <hr class="my-4">
                <strong>Dibuat pada : </strong> <?=date($dokter->created_date)?>
                <br>
                <strong>Terkahir diupdate : </strong> <?= ((date($dokter->updated_date))!=null) ? date($dokter->updated_date) : '-'?>
            </div>
            <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Verifikator')) : ?>
            <div class="col-sm-12">
                <div class="form-group pull-right">
                    <input type = "hidden" id = "btn_submit" name = "btn_submit">
                    <?php if ($dokter->publish == 'False'):?>
                        <?php if($dokter->status == 'Denied'): ?>
                            <button type="submit" id="tolak" class="btn btn-flat bg-red" disabled><i class="fa fa-save"></i> Tolak</button>
                            <button type="submit" id="terima" class="btn btn-flat bg-purple" ><i class="fa fa-save"></i> Terima</button>
                        <?php elseif($dokter->status == 'Verified'): ?>
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