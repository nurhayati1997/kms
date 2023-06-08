<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?=base_url()?>assets/dist/img/user1.png" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?=$user->username?></p>
				<small><?=$user->email?></small>
			</div>
		</div>
		
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MAIN MENU</li>
			<!-- Optionally, you can add icons to the links -->
			<?php 
			$page 		= $this->uri->segment(1);
			$master 	= ["tipe", "unit", "poli", "bidang", "penanggungjawab", "karyawan"];
			$relasi 	= ["unitpenanggungjawab", "tipebidang"];
			$upload 	= ["home", "pelayanan", "informasi", "rsp", "arsip"]; 
			$pelayanan 	= ["unggulan", "igd", "rajal", "ranap", "penunjang"];
			$informasi 	= ["dokter", "ppi", "imut", "jadwal"];
			$rsp 		= ["jejaring", "diklat", "litbang", "elibrary"];

			$users = ["users"];
			?>
			<li class="<?= $page === 'dashboard' ? "active" : "" ?>"><a href="<?=base_url('dashboard')?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<?php if($this->ion_auth->is_admin() || $this->ion_auth->in_group('Kepegawaian')) : ?>
			<li class="treeview <?= in_array($page, $master)  ? "active menu-open" : ""  ?>">
				<a href="#"><i class="fa fa-database"></i> <span>Data Master</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					

					<?php if(!$this->ion_auth->in_group('Kepegawaian') ) : ?>
					<li class="<?=$page==='tipe'?"active":""?>">
						<a href="<?=base_url('tipe')?>">
							<i class="fa fa-circle-o"></i> 
							Master Tipe
						</a>
					</li>
					<li class="<?=$page==='unit'?"active":""?>">
						<a href="<?=base_url('unit')?>">
							<i class="fa fa-circle-o"></i>
							Master Unit
						</a>
					</li>
					<li class="<?=$page==='poli'?"active":""?>">
						<a href="<?=base_url('poli')?>">
							<i class="fa fa-circle-o"></i> 
							Master Poli
						</a>
					</li>
					<li class="<?=$page==='bidang'?"active":""?>">
						<a href="<?=base_url('bidang')?>">
							<i class="fa fa-circle-o"></i>
							Master Bidang
						</a>
					</li>
					<li class="<?=$page==='penanggungjawab'?"active":""?>">
						<a href="<?=base_url('penanggungjawab')?>">
							<i class="fa fa-circle-o"></i>
							Master Penanggung Jawab
						</a>
					</li>
					<?php endif; ?>

					<li class="<?=$page==='karyawan'?"active":""?>">
						<a href="<?=base_url('karyawan')?>">
							<i class="fa fa-circle-o"></i>
							Master Karyawan
						</a>
					</li>
				</ul>
			</li>

			<?php if(!$this->ion_auth->in_group('Kepegawaian') ) : ?>
			<li class="treeview <?= in_array($page, $relasi)  ? "active menu-open" : ""  ?>">
				<a href="#"><i class="fa fa-link"></i> <span>Relasi</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?=$page==='unitpenanggungjawab'?"active":""?>">
						<a href="<?=base_url('unitpenanggungjawab')?>">
							<i class="fa fa-circle-o"></i>
							Unit - Penanggung Jawab
						</a>
					</li>
					<li class="<?=$page==='tipebidang'?"active":""?>">
						<a href="<?=base_url('tipebidang')?>">
							<i class="fa fa-circle-o"></i>
							Tipe - Bidang
						</a>
					</li>
				</ul>
			</li>
			<?php endif; ?>
			<?php endif; ?>

			<?php if( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Tester') ) : ?>
			<li class="<?=$page==='soal'?"active":""?>">
				<a href="<?=base_url('soal')?>" rel="noopener noreferrer">
					<i class="fa fa-question"></i> <span>Bank Soal</span>
				</a>
			</li>
			<?php endif; ?>
			
			<?php if( $this->ion_auth->in_group('Tester') ) : ?>
			<li class="<?=$page==='ujian'?"active":""?>">
				<a href="<?=base_url('ujian/master')?>" rel="noopener noreferrer">
					<i class="fa fa-chrome"></i> <span>Ujian</span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( $this->ion_auth->in_group('Employee') ) : ?>
			<li class="<?=$page==='ujian'?"active":""?>">
				<a href="<?=base_url('ujian/list')?>" rel="noopener noreferrer">
					<i class="fa fa-chrome"></i> <span>Ujian</span>
				</a>
			</li>
			<?php endif; ?>
			<?php if( $this->ion_auth->in_group('Employee') ) : ?>
			<li class="header">REPORTS</li>
			<li class="<?=$page==='hasilujian'?"active":""?>">
				<a href="<?=base_url('hasilujian')?>" rel="noopener noreferrer">
					<i class="fa fa-file"></i> <span>Hasil Ujian</span>
				</a>
			</li>
			<?php endif; ?>


			<?php if( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Verifikator') || $this->ion_auth->in_group('Unit')): ?>
			<li class="header">WEB UPLOAD</li>
			<li class="<?=$page==='berita'?"active":""?>">
				<a href="<?=base_url('berita')?>" rel="noopener noreferrer">
					<i class="fa fa-newspaper-o"></i> <span>Berita</span>
				</a>
			</li>
			<?php endif; ?>

			<?php if( $this->ion_auth->is_admin() || $this->ion_auth->in_group('Creator') || $this->ion_auth->in_group('Verifikator')): ?>
			<li class="treeview <?= in_array($page, $upload)  ? "active menu-open" : ""  ?>">
				<a href="#"><i class="fa fa-list"></i> <span>Upload Konten</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?=$page==='home'?"active":""?>">
						<a href="<?=base_url('home')?>">
							<i class="fa fa-home"></i> 
							Home
						</a>
					</li>
				
					<!-- Pelayanan -->
					<li class="treeview <?= in_array($page, $pelayanan)  ? "active menu-open" : ""  ?>">
						<a href="#"><i class="fa fa-h-square"></i> <span>Pelayanan</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?=$page==='unggulan'?"active":""?>">
								<a href="<?=base_url('pelayanan/unggulan')?>">
									<i class="fa fa-circle-o"></i>
									Layanan Unggulan
								</a>
							</li>
							<li class="<?=$page==='igd'?"active":""?>">
								<a href="<?=base_url('pelayanan/igd')?>">
									<i class="fa fa-circle-o"></i>
									Layanan Gawat Darurat
								</a>
							</li>
							<li class="<?=$page==='rajal'?"active":""?>">
								<a href="<?=base_url('pelayanan/rajal')?>">
									<i class="fa fa-circle-o"></i>
									Layanan Rawat Jalan
								</a>
							</li>
							<li class="<?=$page==='ranap'?"active":""?>">
								<a href="<?=base_url('pelayanan/ranap')?>">
									<i class="fa fa-circle-o"></i>
									Layanan Rawat Inap
								</a>
							</li>
							<li class="<?=$page==='penunjang'?"active":""?>">
								<a href="<?=base_url('pelayanan/penunjang')?>">
									<i class="fa fa-circle-o"></i>
									Layanan Penunjang
								</a>
							</li>
						</ul>
					</li>
					<!-- Informasi -->
					<li class="treeview <?= in_array($page, $informasi)  ? "active menu-open" : ""  ?>">
						<a href="#"><i class="fa fa-info-circle"></i> <span>Informasi</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?=$page==='dokter'?"active":""?>">
								<a href="<?=base_url('informasi/dokter')?>">
									<i class="fa fa-circle-o"></i>
									Dokter
								</a>
							</li>
							<li class="<?=$page==='ppi'?"active":""?>">
								<a href="<?=base_url('informasi/ppi')?>">
									<i class="fa fa-circle-o"></i>
									PPI
								</a>
							</li>
							<li class="<?=$page==='imut'?"active":""?>">
								<a href="<?=base_url('informasi/imut')?>">
									<i class="fa fa-circle-o"></i>
									Indikator Mutu
								</a>
							</li>
							<li class="<?=$page==='jadwal'?"active":""?>">
								<a href="<?=base_url('informasi/jadwal')?>">
									<i class="fa fa-circle-o"></i>
									Jadwal Poli
								</a>
							</li>
						</ul>
					</li>
					<!-- RSP -->
					<li class="treeview <?= in_array($page, $rsp)  ? "active menu-open" : ""  ?>">
						<a href="#"><i class="fa fa-rss-square"></i> <span>RSP</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?=$page==='jejaring'?"active":""?>">
								<a href="<?=base_url('rsp/jejaring')?>">
									<i class="fa fa-circle-o"></i>
									Jejaring Satelit
								</a>
							</li>
							<li class="<?=$page==='diklat'?"active":""?>">
								<a href="<?=base_url('rsp/diklat')?>">
									<i class="fa fa-circle-o"></i>
									Diklat
								</a>
							</li>
							<li class="<?=$page==='litbang'?"active":""?>">
								<a href="<?=base_url('rsp/litbang')?>">
									<i class="fa fa-circle-o"></i>
									Litbang
								</a>
							</li>
							<li class="<?=$page==='elibrary'?"active":""?>">
								<a href="<?=base_url('rsp/elibrary')?>">
									<i class="fa fa-circle-o"></i>
									E-Library
								</a>
							</li>
						</ul>
					</li>
					<!-- Arsip -->
					<li class="<?=$page==='arsip'?"active":""?>">
						<a href="<?=base_url('arsip')?>">
							<i class="fa fa-archive"></i> 
							Arsip
						</a>
					</li>
				</ul>
			</li>

			<li class="<?=$page==='faq'?"active":""?>">
				<a href="<?=base_url('faq')?>" rel="noopener noreferrer">
					<i class="fa fa-comments"></i> <span>FAQ</span>
				</a>
			</li>
			<?php endif; ?>
			
			<?php if($this->ion_auth->is_admin()) : ?>
			<li class="header">ADMINISTRATOR</li>
			<li class="<?=$page==='users'?"active":""?>">
				<a href="<?=base_url('users')?>" rel="noopener noreferrer">
					<i class="fa fa-users"></i> <span>User Management</span>
				</a>
			</li>
			<li class="<?=$page==='settings'?"active":""?>">
				<a href="<?=base_url('settings')?>" rel="noopener noreferrer">
					<i class="fa fa-cog"></i> <span>Settings</span>
				</a>
			</li>
			<?php endif; ?>
		</ul>

	</section>
	<!-- /.sidebar -->
</aside>