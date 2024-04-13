<style>
  .sidebar, li, span, i, a
  {
    color:  black;
    /*border-radius: 0px 10px 10px 0px;*/
  }

  .treeview-menu li, .treeview-menu li a {
    word-wrap: break-word;
    white-space: normal;
  }

  .header
  {
    background-color: #DDDDDD;
    font-weight: 500;
  }

  .treeview-menu .active a
  {
    background-color: #89CFFD;
  }
</style>

<aside class="main-sidebar" style="border-right: 0.5px; border: solid #DDDDDD;">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU UTAMA</li>
      <li class="{{ Request::segment(1) == 'search' ? 'active' : ''  }}"><a href="{{ url('/search/all') }}" target="_blank()"><i class="fa fa-search"></i> CARI BARANG</a></li>
      <li class="treeview {{ (Request::segment(2) == 'good' ) ? 'active' : ''  }}">
        <a href="#">
            <i class="fa fa-cubes"></i><span> Kelola Barang</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ Request::segment(2) == 'good' && Request::segment(3) != 'printDisplay' && Request::segment(3) != 'zeroStock' && Request::segment(3) != 'exp' && Request::segment(3) != 'changeStatus' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good/all/all/all/20') }}"><i class="fa fa-circle-o"></i> Daftar Barang</a></li>
            <li class="{{ Request::segment(2) == 'good' && Request::segment(3) == 'printDisplay' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good/printBarcode') }}"><i class="fa fa-circle-o"></i> Print Barcode Barang</a></li>
            @if($role == 'admin')
              <li class="{{ Request::segment(2) == 'good' && Request::segment(3) == 'zeroStock' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good/zeroStock/all/all/1/0') }}"><i class="fa fa-circle-o"></i> Stock Habis</a></li>
              <li class="{{ Request::segment(2) == 'good' && Request::segment(3) == 'changeStatus' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good/changeStatus') }}"><i class="fa fa-circle-o"></i> Ubah Status Barang</a></li>
            @endif
        </ul>
      </li>
      @if($role == 'admin')
        <li class="treeview {{ Request::segment(2) == 'lebur' ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-fire"></i><span> Kelola Emas Cokim</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="treeview {{ Request::segment(2) == 'lebur' && (Request::segment(3) == 'create' || Request::segment(4) == 'sellOngoing') ? 'active' : ''  }}">
                <a href="#"><i class="fa fa-circle-o"></i> Peleburan Emas Cokim
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'lebur' && Request::segment(3) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/lebur/create') }}"><i class="fa fa-circle-o"></i> Tambah Lebur</a></li>
                  <li class="{{ Request::segment(2) == 'lebur' && Request::segment(3) == 'history' && Request::segment(4) == 'sellOngoing' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/lebur/history/sellOngoing/20') }}"><i class="fa fa-circle-o"></i> Riwayat Peleburan Emas</a></li>
                </ul>
              </li>
              <li class="treeview {{ Request::segment(2) == 'lebur' && (Request::segment(3) == 'sell' || Request::segment(4) == 'sold') ? 'active' : ''  }}">
                <a href="#"><i class="fa fa-circle-o"></i> Penjualan Emas Cokim
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'lebur' && Request::segment(3) == 'sell' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/lebur/sell') }}"><i class="fa fa-circle-o"></i> Tambah Penjualan</a></li>
                  <li class="{{ Request::segment(2) == 'lebur' && Request::segment(3) == 'history' && Request::segment(4) == 'sold' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/lebur/history/sold/20') }}"><i class="fa fa-circle-o"></i> Riwayat Penjualan Emas</a></li>
                </ul>
              </li>
              <li class="treeview {{ Request::segment(2) == 'lebur' && (Request::segment(3) == 'createNew' || Request::segment(4) == 'newGold') ? 'active' : ''  }}">
                <a href="#"><i class="fa fa-circle-o"></i> Pembuatan Emas dari Cokim
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'lebur' && Request::segment(3) == 'createNew' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/lebur/createNew') }}"><i class="fa fa-circle-o"></i> Buat Emas Baru dari Cokim</a></li>
                  <li class="{{ Request::segment(2) == 'lebur' && Request::segment(3) == 'history' && Request::segment(4) == 'newGold' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/lebur/history/newGold/20') }}"><i class="fa fa-circle-o"></i> Riwayat Pembuatan Emas</a></li>
                </ul>
              </li>
          </ul>
        </li>
      @endif
      @if($role == 'admin' || \Auth::user()->role == 'kulak_cashier') 
        <li class="treeview {{ (Request::segment(2) == 'good-loading' && Request::segment(3) == 'loading' ) ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-truck"></i><span> Kulak Emas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'good-loading' && Request::segment(4) == 'create' && Request::segment(3) == 'loading' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good-loading/loading/create') }}"><i class="fa fa-circle-o"></i> Tambah Kulak Emas</a></li>
              <li class="{{ Request::segment(2) == 'good-loading' && Request::segment(4) != 'create' && Request::segment(3) == 'loading' && Request::segment(4) != 'excel' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good-loading/loading/' . date('Y-m-d') . '/' . date('Y-m-d') . '/all/50') }}"><i class="fa fa-circle-o"></i> Daftar Kulak Emas</a></li>
          </ul>
        </li>
      @endif
      @if($role == 'admin' || \Auth::user()->role == 'pembelian_cashier') 
        <li class="treeview {{ (Request::segment(2) == 'good-loading' && Request::segment(3) != 'loading' ) ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-dollar"></i><span> Pembelian Emas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'good-loading' && Request::segment(4) == 'create' && Request::segment(3) == 'buy' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good-loading/buy/create') }}"><i class="fa fa-circle-o"></i> Pembelian Emas dengan Surat</a></li>
              <li class="{{ Request::segment(2) == 'good-loading' && Request::segment(4) == 'create' && Request::segment(3) == 'buy-other' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good-loading/buy-other/create') }}"><i class="fa fa-circle-o"></i> Pembelian Emas tanpa Surat</a></li>
              <li class="{{ Request::segment(2) == 'good-loading' && Request::segment(4) != 'create' && Request::segment(3) != 'loading' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/good-loading/all/' . date('Y-m-d') . '/' . date('Y-m-d') . '/all/50') }}"><i class="fa fa-circle-o"></i> Daftar Pembelian Emas</a></li>
          </ul>
        </li>
      @endif
      @if($role == 'admin' || \Auth::user()->role == 'penjualan_cashier') 
        <li class="treeview {{ (Request::segment(2) == 'transaction' ) ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-money"></i><span> Penjualan Emas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'transaction' && Request::segment(3) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/transaction/create') }}"><i class="fa fa-circle-o"></i> Tambah Penjualan</a></li>
              <li class="{{ Request::segment(2) == 'transaction' && Request::segment(3) != 'create' && Request::segment(3) != 'resume' && Request::segment(3) != 'resumeTotal' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/transaction/all/all/' . date('Y-m-d') . '/' . date('Y-m-d') . '/20') }}"><i class="fa fa-circle-o"></i> Daftar Penjualan</a></li>
          </ul>
        </li>
      @endif
      @if($role == 'admin')
        <li class="header">MENU LAIN</li>
        <li class="treeview {{ (Request::segment(2) == 'distributor' && Request::segment(3) == 'seller') ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-truck"></i><span> Kelola Penjual Emas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'distributor' && Request::segment(3) == 'seller' && Request::segment(4) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/distributor/seller/create') }}"><i class="fa fa-circle-o"></i> Tambah Penjual Emas</a></li>
              <li class="{{ Request::segment(2) == 'distributor' && Request::segment(3) == 'seller' && Request::segment(4) != 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/distributor/seller/15') }}"><i class="fa fa-circle-o"></i> Daftar Penjual Emas</a></li>
          </ul>
        </li>
        <li class="treeview {{ (Request::segment(2) == 'distributor' && Request::segment(3) == 'sales') ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-truck"></i><span> Kelola Sales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'distributor' && Request::segment(3) == 'sales' && Request::segment(4) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/distributor/sales/create') }}"><i class="fa fa-circle-o"></i> Tambah Sales</a></li>
              <li class="{{ Request::segment(2) == 'distributor' && Request::segment(3) == 'sales' && Request::segment(4) != 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/distributor/sales/15') }}"><i class="fa fa-circle-o"></i> Daftar Sales</a></li>
          </ul>
        </li>
        <li class="treeview {{ (Request::segment(2) == 'category' ) ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-shopping-cart"></i><span> Kelola Kategori</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'category' && Request::segment(3) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/category/create') }}"><i class="fa fa-circle-o"></i> Tambah Kategori</a></li>
              <li class="{{ Request::segment(2) == 'category' && Request::segment(3) != 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/category/15') }}"><i class="fa fa-circle-o"></i> Daftar Kategori</a></li>
          </ul>
        </li>
        <li class="treeview {{ (Request::segment(2) == 'member' ) ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-users"></i><span> Kelola Member</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'member' && Request::segment(3) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/member/create') }}"><i class="fa fa-circle-o"></i> Tambah Member</a></li>
              <li class="{{ Request::segment(2) == 'member' && Request::segment(3) != 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/member/15') }}"><i class="fa fa-circle-o"></i> Daftar Member</a></li>
          </ul>
        </li>
        <li class="treeview {{ (Request::segment(2) == 'percentage' ) ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-percent"></i><span> Kelola Persentase</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'percentage' && Request::segment(3) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/percentage/create') }}"><i class="fa fa-circle-o"></i> Tambah Persentase</a></li>
              <li class="{{ Request::segment(2) == 'percentage' && Request::segment(3) != 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/percentage/15') }}"><i class="fa fa-circle-o"></i> Daftar Persentase</a></li>
          </ul>
        </li>
      @endif
      <!-- @if(\Auth::user()->email == 'admin')
        <li class="header">LAPORAN KEUANGAN</li>
        <li class="treeview {{ (Request::segment(2) == 'account' ) ? 'active' : ''  }}">
          <a href="#">
              <i class="fa fa-book"></i><span> Kelola Akun</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="{{ Request::segment(2) == 'account' && Request::segment(3) == 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/account/create') }}"><i class="fa fa-circle-o"></i> Tambah Akun</a></li>
              <li class="{{ Request::segment(2) == 'account' && Request::segment(3) != 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/account/15') }}"><i class="fa fa-circle-o"></i> Daftar Akun</a></li>
          </ul>
        </li>
        <li class="{{ Request::segment(2) == 'journal' && Request::segment(3) != 'create' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/journal/all/' . date('Y-m-d') . '/' . date('Y-m-d') . '/15') }}"><i class="fa fa-calculator"></i> Jurnal</a></li>
        <li class="{{ Request::segment(2) == 'profit' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/profit') }}"><i class="fa fa-arrow-circle-up"></i> Laba Rugi</a></li>
        <li class="{{ Request::segment(2) == 'scale' ? 'active' : ''  }}"><a href="{{ url('/' . $role . '/scale') }}"><i class="fa fa-balance-scale"></i> Neraca</a></li>
      @endif -->
    </ul>
  </section>
</aside>
