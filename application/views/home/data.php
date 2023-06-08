<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Visi</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('home/add/Visi') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('Visi')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('Visi')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('home/delete', array('id' => 'bulk_Visi')) ?>
        <table id="Visi" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Visi</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_visi">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>

<!-- Misi -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Misi</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>    
                <a href="<?= base_url('home/add/Misi') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('Misi')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('Misi')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('home/delete', array('id' => 'bulk_Misi')) ?>
        <table id="Misi" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Misi</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_misi">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>

<!-- Maklumat -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Maklumat Pelayanan</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('home/add/Maklumat') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('Maklumat')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('Maklumat')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('home/delete', array('id' => 'bulk_Maklumat')) ?>
        <table id="Maklumat" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Maklumat</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_maklumat">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>

<!-- Motto -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Motto</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('home/add/Motto') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('Motto')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('Motto')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('home/delete', array('id' => 'bulk_Motto')) ?>
        <table id="Motto" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Motto</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_motto">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>

<!-- Slogan -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Slogan</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('home/add/Slogan') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('Slogan')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('Slogan')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('home/delete', array('id' => 'bulk_Slogan')) ?>
        <table id="Slogan" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Slogan</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_slogan">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>

<!-- Motto -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Janji Pelayanan</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>   
                <a href="<?= base_url('home/add/Janji') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('Janji')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('Janji')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('home/delete', array('id' => 'bulk_Janji')) ?>
        <table id="Janji" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Janji Pelayanan</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_janji">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>

<!-- IKM -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">IKM (Indeks Kepuasan Masyarakat)</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="mt-2 mb-4">
            <?php if ( !$this->ion_auth->in_group('Verifikator') ) : ?>
                <a href="<?= base_url('home/add/IKM') ?>" class="btn btn-sm bg-purple btn-flat"><i class="fa fa-plus"></i> Tambah Data</a>
            <?php endif; ?>
            <button type="button" onclick="reload('IKM')" class="btn btn-sm btn-default btn-flat"><i class="fa fa-refresh"></i> Reload</button>
            <div class="pull-right">
                <?php if ( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Unit')) : ?>
                    <button onclick="bulk_delete('IKM')" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                <?php endif; ?>
            </div>
        </div>
        <?= form_open('home/delete', array('id' => 'bulk_IKM')) ?>
        <table id="IKM" class="w-100 table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>IKM</th>
                    <th>Created On</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">
                        <input type="checkbox" class="select_all_ikm">
                    </th>
                </tr>
            </thead>
        </table>
        <?= form_close() ?>
    </div>
</div>
<script src="<?= base_url() ?>assets/dist/js/app/home/data.js"></script>