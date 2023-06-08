<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Master Data Pelayanan Penunjang</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('pelayanan/penunjang/add') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload_ajax()" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Creator')) : ?>
                    <button onclick="bulk_delete()" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('pelayanan/penunjang/delete', array('id' => 'bulk')) ?>
        <table id="datatable" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Ruangan</th>
                    <th>Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>
<script src="<?= base_url() ?>assets/dist/js/app/pelayanan/penunjang/data.js"></script>