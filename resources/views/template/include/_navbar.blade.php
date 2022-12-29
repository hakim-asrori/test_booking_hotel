<link rel="stylesheet" href="{{ asset('style/css/navbar.css') }}">
<nav class="navbar navbar-expand navbar-light px-1 bg-white shadow-sm" style="height: 55px">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('img/logo/sip.png') }}" alt="" width="40" height="40"
                class="d-inline-block align-text-top">
        </a>
        <div id="menu-toggle">
            <div class="text-center d-inline-block" data-bs-toggle="tooltip" data-bs-placement="right"
                title="Toggle Sidebar">
                <div class="vc-toggle-container">
                    <label class="vc-switch">
                        <input type="checkbox" class="vc-switch-input">
                        <span class="vc-switch-label"></span>
                        <span class="vc-handle"></span>
                    </label>
                </div>
            </div>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="dropdown ms-auto me-4" id="refreshThisDropdown">
                <div class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="btn position-relative bg-icon">
                        <i class="fas fa-bell">
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="position-absolute mt-1 top-0 start-100 translate-middle badge rounded-pill bg-secondary">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                    <span class="visually-hidden">Pesan yang belum dibaca</span></span>
                            @endif
                        </i>
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                    <div class="row">
                        <div class="col-lg-12">
                            <li role="presentation">
                                <div class="dropdown-header">Pemberitahuan</div>
                            </li>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="timeline timeline-icons timeline-sm p-2"
                                style="width:210px; max-height:300px; overflow:auto">
                                @forelse (auth()->user()->unreadNotifications as $notification)
                                    <li>
                                        <p>
                                            {{ $notification->data['message'] }}
                                            <a href="{{ route('notification.routeTo',['id' => $notification->id]) }}">disini</a>
                                            {{-- <a href="{{ $notification->data['url'] }}">here</a> --}}
                                            <span class="timeline-icon" style="margin-left: -1px; margin-top:-3px"><i
                                                    class="fa fa-cash-register"></i></span>
                                            <span
                                                class="timeline-date">{{ $notification->created_at->diffForHumans() }}</span>
                                        </p>
                                    </li>
                                @empty
                                    <p class="text-center">
                                        Tidak ada pemberitahuan baru
                                    </p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <li role="presentation">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{ route('notification.markAllAsRead') }}"
                                            class="float-start mb-4 ms-4">Tandai semua</a>
                                        <a href="{{ route('notification.index') }}" class="float-end mb-2 me-2">Lihat semua
                                            </a>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </div>
                </ul>

            </div>
            <div class="dropdown">
                <div class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->getAvatar() }}" class="rounded-circle img-thumbnail"
                        style="cursor: pointer" width="40" height="40" alt="">
                </div>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item"
                            href="{{ route('user.show', ['user' => auth()->user()->id]) }}">Profil</a>
                    </li>
                    <li><a class="dropdown-item" href="#">Aktifitas</a></li>
                    <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <form action="/logout" method="POST">
                        @csrf
                        <li><button class="dropdown-item" type="submit">Keluar</button></li>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>
