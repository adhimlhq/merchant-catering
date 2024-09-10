<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->


        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboards </span>
                    </a>
                </li>

                {{-- @if (Auth::user()->can('pos.menu'))
                    <li>
                        <a href="{{ route('pos') }}">
                            <span class="badge bg-pink float-end">Hot</span>
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> POS </span>
                        </a>
                    </li>
                @endif --}}

                <li class="menu-title mt-2">App</li>
                <li>
                    <a href="#sidebarMrc" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-cog"></i>
                        <span> Toko Anda </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMrc">
                        <ul class="nav-second-level">
                            <li>
                                @if (Auth::check() && \App\Models\Merchant::where('user_id', Auth::id())->exists())
                                    <!-- Jika pengguna ada di tabel merchant, tampilkan link -->
                                    <a href="{{ route('merchant.index') }}">Lihat Merchant</a>
                                @else
                                    <!-- Jika pengguna tidak ada di tabel merchant, arahkan ke route create.merchant -->
                                    <a href="{{ route('merchant.create') }}">Buat Merchant</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </li>




            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
