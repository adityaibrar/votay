@php
use Illuminate\Support\Facades\Log;
@endphp
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"> --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
/* Reset dan Custom CSS untuk mengontrol submenu */
.metismenu ul {
    display: none !important;
    opacity: 0;
    transition: all 0.3s ease;
}

.metismenu li.mm-active > ul {
    display: block !important;
    opacity: 1;
}

.metismenu .mm-show {
    display: block !important;
    opacity: 1;
}

.metismenu .mm-collapse {
    display: none !important;
    opacity: 0;
}

/* Memastikan submenu tidak tampil secara default */
.metismenu li ul {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, opacity 0.3s ease;
}

.metismenu li.mm-active ul {
    max-height: 200px;
    overflow: visible;
}

/* Override untuk memastikan submenu bekerja dengan baik */
.metismenu .has-arrow:after {
    transition: transform 0.3s ease;
}

.metismenu .mm-active > .has-arrow:after {
    transform: rotate(-90deg);
}

/* Reset any conflicting styles */
.metismenu ul ul {
    display: none !important;
}
</style>

<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">
            <div class="image-bx">
                <img src="{{ auth()->user()->poto ? asset('storage/' . auth()->user()->poto) : asset('dash/images/logo_osis.png') }}" width="20" height="30" alt="">
            </div>
            <h5 class="name"><span class="font-w400">Hello,</span>{{auth()->user()->name}}</h5>
            <p class="email"><a href="javascript:void(0);" class="cf_email">{{auth()->user()->email}}</a></p>
        </div>
           @php
          
                $permissions = session('permissions') ?? [];
          Log::alert($permissions);
            @endphp

        <ul class="metismenu" id="menu">
         @if(in_array('Home',$permissions))   
            @can('Home')
            <li class="nav-label first"></li>
            <li><a  href="/home" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            <li><a  href="/petunjuk" aria-expanded="false">
                <i class="bi bi-journal"></i>
                <span class="nav-text">Petunjuk Penggunaan</span>
            </a>
        </li>
            @endcan
@endif

{{-- Menu Vote untuk semua user yang login --}}
@php
    $settings = App\Models\SettingWaktu::first();
    $showVote = false;
    if($settings && \Carbon\Carbon::now()->isSameDay(\Carbon\Carbon::parse($settings->waktu))) {
        $showVote = true;
    }
@endphp

@if ($showVote)
<li><a href="/vote" aria-expanded="false">
        <i class="flaticon-077-menu-1"></i>
        <span class="nav-text">Vote</span>
    </a>
</li>
@endif

         @if(in_array('User',$permissions))   
            @can('User')
            <li class="{{ request()->is('user*') || request()->is('add_user') ? 'mm-active active-no-child' : '' }}">
                <a href="/user" aria-expanded="{{ request()->is('user*') || request()->is('add_user') ? 'true' : 'false' }}" class="{{ request()->is('user*') || request()->is('add_user') ? 'mm-active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span class="nav-text">Data User</span>
                </a>
            </li>
            @endcan
@endif

 @if(in_array('Data Calon OSIS',$permissions))
                 @can('Data Calon OSIS')
                <li class="{{ request()->is('calonosis*') || request()->is('add_osis') ? 'mm-active active-no-child' : '' }}">
                    <a href="/calon-osis" aria-expanded="{{ request()->is('calonosis*') || request()->is('add_osis') ? 'true' : 'false' }}" class="{{ request()->is('calonosis*') || request()->is('add_osis') ? 'mm-active' : '' }}">
                    <i class="bi bi-person-vcard"></i>
                        <span class="nav-text">Data Calon OSIS</span>
                    </a>
                </li>
                @endcan
            @endif

  @if(in_array('Laporan', $permissions))
    @can('Laporan')
        <li class="{{ request()->is('laporan*') ? 'mm-active' : '' }}">
            <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span class="nav-text">Laporan</span>
            </a>
            <ul aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}">
                <li class="{{ request()->is('laporan-polling') ? 'mm-active' : '' }}">
                    <a href="/laporan-polling">
                        <i class="bi bi-database-lock"></i>
                        <span class="nav-text">Data Polling</span>
                    </a>
                </li>
                <li class="{{ request()->is('laporan-voted') ? 'mm-active' : '' }}">
                    <a href="/laporan-voted">
                        <i class="bi bi-database-add"></i>
                        <span class="nav-text">Data Voted</span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan
@endif

         @if(in_array('Setting',$permissions))   
            @can('Setting')
            <li class="{{ request()->is('role*') || request()->is('add_role') || request()->is('setting-waktu') ? 'mm-active' : '' }}">
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="{{ request()->is('role*') || request()->is('add_role') || request()->is('setting-waktu') ? 'true' : 'false' }}">
                    <i class="bi bi-gear"></i>
                    <span class="nav-text">Pengaturan</span>
                </a>
                <ul aria-expanded="{{ request()->is('role*') || request()->is('add_role') || request()->is('setting-waktu') ? 'true' : 'false' }}">
                    <li class="{{ request()->is('role*') || request()->is('add_role') ? 'mm-active' : '' }}">
                        <a href="/role" aria-expanded="false">
                            <i class="fa fa-user-cog"></i>
                            <span class="nav-text">Role</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('setting-waktu') ? 'mm-active' : '' }}">
                        <a href="/setting-waktu" aria-expanded="false">
                        <i class="bi bi-calendar2-week"></i>
                            <span class="nav-text">Waktu</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
         @endif
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hapus event listener yang mungkin sudah ada
    $('#menu').off();
    
    // Inisialisasi metisMenu dengan pengaturan yang tepat
    if (typeof $.fn.metisMenu !== 'undefined') {
        $('#menu').metisMenu({
            toggle: true,
            preventDefault: false,
            activeClass: 'mm-active',
            collapseClass: 'mm-collapse',
            collapseInClass: 'mm-collapsing'
        });
    }
    
    // Pastikan hanya submenu yang sesuai route yang terbuka
    $('.mm-active').each(function() {
        var $this = $(this);
        var $submenu = $this.find('> ul');
        if ($submenu.length && $this.hasClass('mm-active')) {
            $submenu.show().addClass('mm-show');
            $this.find('> a').attr('aria-expanded', 'true');
        }
    });
    
    // Sembunyikan semua submenu yang tidak aktif
    $('.metismenu li').not('.mm-active').each(function() {
        var $submenu = $(this).find('> ul');
        if ($submenu.length) {
            $submenu.hide().removeClass('mm-show');
            $(this).find('> a').attr('aria-expanded', 'false');
        }
    });
});
</script>