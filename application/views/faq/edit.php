<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form <?=$judul?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6">
                <div class="my-2">
                    <div class="form-horizontal form-inline">
                        <a href="<?=base_url('faq')?>" class="btn btn-default btn-xs">
                            <i class="fa fa-arrow-left"></i> Batal
                        </a>
                        <div class="pull-right">
                            <span> Jumlah : </span><label for=""><?=count($faq)?></label>
                        </div>
                    </div>
                </div>
                <?=form_open('faq/save', array('id'=>'faq'), array('mode'=>'edit'))?>
                <table id="form-table" class="table text-center table-condensed">
                    <thead>
                        <tr>
                            <th># No</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        foreach($faq as $row) : ?> 
                            <tr>
                                <td><?=$i?></td>
                                <td>
                                    <div class="form-group">
                                        <?=form_hidden('id_faq['.$i.']', $row->id_faq);?>
                                        <input required="required" autofocus="autofocus" onfocus="this.select()" value="<?=$row->pertanyaan?>" type="text" name="pertanyaan[<?=$i?>]" class="form-control">
                                        <span class="d-none">DON'T DELETE THIS</span>
                                        <small class="help-block text-right"></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input required="required" autofocus="autofocus" onfocus="this.select()" value="<?=$row->jawaban?>" type="text" name="jawaban[<?=$i?>]" class="form-control">
                                        <span class="d-none">DON'T DELETE THIS</span>
                                        <small class="help-block text-right"></small>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++;endforeach; ?>
                    </tbody>
                </table>
                <button id="submit"  type="submit" class="mb-4 btn btn-block btn-flat bg-purple">
                    <i class="fa fa-edit"></i> Simpan Perubahan
                </button>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url()?>assets/dist/js/app/faq/edit.js"></script>