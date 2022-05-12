<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{Fungsi::aplikasijudulsingkat()}} | {{ucfirst($pages)}} </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("assets/") }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset("assets/") }}/plugins/toastr/toastr.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset("assets/") }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("assets/") }}/dist/css/adminlte.min.css">
  {{-- <link rel="stylesheet" href="{{ asset("assets/") }}/plugins/select2/css/select2.min.css"> --}}
  <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xgit Zd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
crossorigin="anonymous"></script> --}}
<style>
    .imgprofile {
  width: 10px;
  height: 10px;
  object-fit: cover;
}
</style>
  @yield('csshere')

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route("admin.buku") }}" class="nav-link">Pilih Buku</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route("admin.peminjaman") }}" class="nav-link" id="jmldatabuku">Pinjam</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route("admin.pengembalian") }}" class="nav-link"  id="jmldatabukukembali">Kembalikan</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Anggota</a>
      </li> --}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <script>
        $(function () {
          var jmlpinjamlocal=localStorage.length;
          // alert(jmlpinjamlocal);
            // let daftarbuku=0;
            // if (localStorage.getItem('daftarbuku') === null) {
            //     daftarbuku = [];
            // } else {
            //     daftarbuku = JSON.parse(localStorage.getItem('daftarbuku'));
            // }
        // alert(daftarbuku.length);

        // $("#jmldatabuku").append('<span class="badge badge-info navbar-badge">'+daftarbuku.length+'</span>');
        $("#jmldatabuku").append('<span class="badge badge-info navbar-badge">'+jmlpinjamlocal+'</span>');


        // let daftarkembali=0;
        //     if (localStorage.getItem('daftarkembali') === null) {
        //         daftarkembali = [];
        //     } else {
        //         daftarkembali = JSON.parse(localStorage.getItem('daftarkembali'));
        //     }
        // alert(daftarbuku.length);

        // $("#jmldatabuku").append('<span class="badge badge-info navbar-badge">'+daftarbuku.length+'</span>');
        // $("#jmldatabukukembali").append('<span class="badge badge-success navbar-badge">'+daftarkembali.length+'</span>');
        // $("#jmldatabuku").append('<span class="badge badge-info navbar-badge">'+daftarbuku.length+'</span>');
        // $("#jmldatabukukembali").append('<span class="badge badge-success navbar-badge">0</span>');
        });
      </script>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" >
          <i class="fas fa-cog"></i>

        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          {{-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user-cog"></i> Profil
          </a> --}}
          <div class="dropdown-divider"></div>
          <a href="{{route('admin.settings')}}" class="dropdown-item">
            <i class="fas fa-cogs"></i> Pengaturan
          </a>
          <div class="dropdown-divider"></div>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf


                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault();
                            this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt">
                    </i> Logout
                  </a>
        </form>
          {{-- <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> <span class=" text-muted text-sm">Logout</span>

          </a> --}}
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url("/katalog") }}" class="brand-link">
      {{-- <img src="{{ asset("assets/") }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <img src="{{ asset("assets/") }}/upload/logoyayasan.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{Fungsi::aplikasijudul()}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @if((Auth::user()->profile_photo_path!='')AND(Auth::user()->profile_photo_path!=null))
          <img src="{{ asset("storage/") }}/{{ Auth::user()->profile_photo_path }}" class="img-circle elevation-2  img-fluid imgprofile" id="imgprofile" alt="User Image" >
            @else
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=7F9CF5&background=EBF4FF" class="img-circle elevation-2  img-fluid imgprofile" id="imgprofile" alt="User Image" >

            @endif
        </div>
        <div class="info">
            <a href="{{route('admin.users.myprofile')}}"  class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ asset("assets/") }}/index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ asset("assets/") }}/index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ asset("assets/") }}/index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul> --}}
          </li>


        @if(((Auth::user()->tipeuser)=='admin'))
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link">
                <i class="fas fa-home"></i>
              <p>
                Beranda
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.settings')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Pengaturan
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          <li class="nav-header">MASTER</li>
          {{-- <li class="nav-item">
          <a href="{{ route('admin.bukurak') }}" class="nav-link">
            <i class="fas fa-box-open"></i>
            <p>Rak Buku</p>
          </a> --}}
        </li>
          {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-archive"></i>
            <p>Kategori</p>
          </a>
        </li> --}}
        <li class="nav-item">
          <a href="{{ route('admin.buku') }}" class="nav-link">
            <i class="fas fa-book"></i>
            <p>Buku</p>
          </a>
        </li>
          <li class="nav-item">
            <a href="{{route('admin.laporan.pengunjung')}}" class="nav-link">
              <i class="far fa-user"></i>
              <p>Pengunjung</p>
            </a>
          </li>
          <li class="nav-item">
          <a href="{{route('admin.anggota')}}" class="nav-link">
            <i class="fas fa-user-tie"></i>
            <p>Anggota</p>
          </a>
        </li>
        <li class="nav-item">
        <a href="{{route('admin.peralatan')}}" class="nav-link">
          <i class="fas fa-screwdriver"></i>
          <p>Peralatan</p>
        </a>
      </li>
      <li class="nav-item">
      <a href="{{route('admin.bukudigital')}}" class="nav-link">
        <i class="fas fa-atlas"></i>
        <p>Buku Digital</p>
      </a>
    </li>
        <li class="nav-item">
        <a href="{{route('admin.users')}}" class="nav-link">
            <i class="fas fa-user-lock"></i>
          <p>User</p>
        </a>
      </li>
          <li class="nav-header">PROSES</li>
          <li class="nav-item">
            <a href="{{route('admin.peminjaman')}}" class="nav-link">
              <i class="fas fa-calendar-plus"></i>
              <p>Pinjam</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.pengembalian')}}" class="nav-link">
              <i class="far fa-calendar-check"></i>
              <p>Kembalikan</p>
            </a>
          </li>

          <li class="nav-header">KEUANGAN</li>
          <li class="nav-item">
            <a href="{{route('admin.pemasukan')}}" class="nav-link">
              <i class="fas fa-hand-holding-usd"></i>
              <p>Pemasukan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.pengeluaran')}}" class="nav-link">
              <i class="far fa-money-bill-alt"></i>
              <p>Pengeluaran</p>
            </a>
          </li>
          <li class="nav-header">REPORT</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Invoice
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.peminjaman.invoicepeminjaman')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Peminjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.pengembalian.invoicepengembalian')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengembalian</p>
                </a>
              </li>

            </ul>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-money-check-alt"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.laporan.peminjaman')}}" class="nav-link">
                  <i class="fas fa-user-clock"></i>
                  <p>Laporan Peminjaman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.laporan.keuangan')}}" class="nav-link">
                  <i class="fas fa-money-check-alt"></i>
                  <p>Laporan Keuangan</p>
                </a>
              </li>


              @else

              <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link">
                    <i class="fas fa-home"></i>
                  <p>
                    Beranda
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
              </li>

            <li class="nav-item">
              <a href="{{ route('pustakawan.buku') }}" class="nav-link">
                <i class="fas fa-book"></i>
                <p>Buku</p>
              </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.bukudigital')}}" class="nav-link">
                <i class="fas fa-atlas"></i>
                <p>Buku Digital</p>
                </a>
            </li>
            <li class="nav-header">PROSES</li>
            <li class="nav-item">
              <a href="{{route('admin.peminjaman')}}" class="nav-link">
                <i class="fas fa-calendar-plus"></i>
                <p>Pinjam</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.pengembalian')}}" class="nav-link">
                <i class="far fa-calendar-check"></i>
                <p>Kembalikan</p>
              </a>
            </li>
            <li class="nav-header">REPORT</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Invoice
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('admin.peminjaman.invoicepeminjaman')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Peminjaman</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.pengembalian.invoicepengembalian')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pengembalian</p>
                  </a>
                </li>

              </ul>

              @endif

            </ul>
{{--
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-users"></i>
              <p>Laporan Pengunjung</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-user-clock"></i>
              <p>Laporan Peminjaman</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-money-check-alt"></i>
              <p>Laporan Keuangan</p>
            </a>
          </li> --}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      @yield('container')
  </div>

      @yield('container-modals')
      @yield('notif')
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@yield('jshere')
<!-- jQuery -->
<script src="{{ asset("assets/") }}/plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="{{ asset("assets/") }}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ asset("assets/") }}/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="{{ asset("assets/") }}/plugins/toastr/toastr.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset("assets/") }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset("assets/") }}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("assets/") }}/dist/js/demo.js"></script>


</body>
</html>
