<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assets/uploads/clientes/<?= $user['foto'] ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $user["nome"] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU DE NAVEGAÇÃO</li>
        <li><a href="<?= site_url('cliente') ?>"><i class="fa fa-user-o"></i> <span>Clientes</span></a></li>
        <li><a href="<?= site_url('planta') ?>"><i class="fa fa-home"></i> <span>Instalações</span></a></li>
        <li><a href="<?= site_url('placas') ?>"><i class="fa fa-th"></i> <span>Painéis</span></a></li>                
        <li><a href="<?= site_url('falhas') ?>"><i class="fa fa-thumbs-down"></i> <span>Falhas</span>
                <small class="label pull-right bg-red falhas d.none">3</small></a></li>
                
        
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentação</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>