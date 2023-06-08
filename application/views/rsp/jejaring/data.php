<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Master Data Jejaring Satelit</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('rsp/jejaring/add/Jejaring') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('jejaring')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('jejaring')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('rsp/jejaring/delete', array('id' => 'bulk_jejaring')) ?>
        <table id="jejaring" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_jejaring">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>

<!-- Praktik Dokter -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Master Data Praktik Dokter</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('rsp/jejaring/add/Praktik') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('praktik')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('praktik')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('rsp/jejaring/delete', array('id' => 'bulk_praktik')) ?>
        <table id="praktik" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_praktik">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>
<script src="<?= base_url() ?>assets/dist/js/app/rsp/jejaring/data.js"></script>