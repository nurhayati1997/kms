<?=form_open_multipart('home/verify', array('id'=>'formverifikasi'), array('id_home'=>$home->id_home));?>
<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Detail Konten <?=$home->kategori?></h3>
        <div class="pull-right">
            <a href="<?=base_url()?>home" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <!--<a href="<?=base_url()?>home/edit/<?=$this->uri->segment(3)?>" class="btn btn-xs btn-flat btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>-->
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                
                <?php if ($home->kategori == 'IKM') : ?>    
                    <?php if(!empty($home->file)): ?>
                        <div class="w-50">
                            <?= tampil_media('uploads/home/'.$home->file); ?>
                        </div>
                    <?php endif; ?>
                    <strong>Deskripsi :</strong>
                    <?=$home->deskripsi?>
                <?php else: ?>
                    <strong><?=$home->kategori?> :</strong>
                    <?=$home->deskripsi?>
                <?php endif; ?>
                
                <hr class="my-4">
                <strong>Dibuat pada : </strong> <?=date($home->created_date)?>
                <br>
                <strong>Terkahir diupdate : </strong> <?= ((date($home->updated_date))!=null) ? date($home->updated_date) : '-'?>
            </div>
            <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Verifikator')) : ?>
            <div class="col-sm-12">
                <div class="form-group pull-right">
                    <input type = "hidden" id = "btn_submit" name = "btn_submit">
                    <?php if ($home->publish == 'False'):?>
                        <?php if($home->status == 'Denied'): ?>
                            <button type="submit" id="tolak" class="btn btn-flat bg-red" disabled><i class="fa fa-save"></i> Tolak</button>
                            <button type="submit" id="terima" class="btn btn-flat bg-purple" ><i class="fa fa-save"></i> Terima</button>
                        <?php elseif($home->status == 'Verified'): ?>
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