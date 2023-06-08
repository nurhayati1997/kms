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
        	<div class="col-sm-4">
				<?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
					<button type="button" onclick="bulk_delete()" class="btn btn-flat btn-sm bg-red"><i class="fa fa-trash"></i> Bulk Delete</button>
				<?php endif; ?>
			</div>
			<div class="form-group col-sm-4 text-center">
				<select id="jenis_filter" class="form-control select2" style="width:100% !important">
					<option value="all">Semua Jenis Pelayanan</option>
					<option value="unggulan">Unggulan</option>
					<option value="igd">Gawat Darurat</option>
					<option value="rajal">Rawat Jalan</option>
					<option value="ranap">Rawat Inap</option>
					<option value="penunjang">Penunjang</option>
				</select>				
			</div>
			<div class="col-sm-4">
				<div class="pull-right">
					<?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
						<a href="<?=base_url('pelayanan/add')?>" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-plus"></i> Add</a>
					<?php endif; ?>
					<button type="button" onclick="reload_ajax()" class="btn btn-flat btn-sm bg-maroon"><i class="fa fa-refresh"></i> Reload</button>
				</div>
			</div>
		</div>
    </div>
	<?=form_open('pelayanan/delete', array('id'=>'bulk'))?>
    <div class="table-responsive px-4 pb-3" style="border: 0">
        <table id="soal" class="w-100 table table-striped table-bordered table-hover">
        <thead>
            <tr>
				<th class="text-center">
					<input type="checkbox" class="select_all">
				</th>
                <th width="25">No.</th>
				<th>Pelayanan</th>
				<th>File <small>(jpeg | jpg | png | gif)</small></th>
				<th>Jenis</th>
				<th>Tanggal</th>
				<th class="text-center">Status</th>
				<th class="text-center">Aksi</th>
            </tr>        
        </thead>
        </table>
    </div>
	<?=form_close();?>
</div>

<script src="<?=base_url()?>assets/dist/js/app/pelayanan/data.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	let pj = '<?=$pelayanan->id?>';
	let src = '<?=base_url()?>pelayanan/data';
	let url;

	url = src + '/' + pj + '/All';
	table.ajax.url(url).load();
	
	$('#jenis_filter').on('change', function(){
		let jenis = $(this).val();
		
		if(jenis !== 'all'){
			let src2 = src + '/' + pj + '/' + jenis;
			url = $(this).prop('checked') === true ? src : src2;
		}else{
			url = src + '/' + pj + '/All';
		}
		table.ajax.url(url).load();
	});
});
</script>
