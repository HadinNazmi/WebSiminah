
<div class="user-status-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-6">
                        @if (isAdminKelurahan())
                            <a href="{{ route('profil') }}">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6 image">
                                        <x-user.userImage role="admin"/>
                                        <div class="aktif"></div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6 name ">
                                        @if (Auth::check())
                                            {{-- <span>{{ Str::substr(str_replace('admin', '', Auth::user()->name), 0, 9) }}</span> --}}
                                            <span class="overflow-auto">
                                                {{ getFirstName(Auth::user()->name) }}
                                            </span>
                                        @endif

                                    </div>
                                </div>
                            </a>
                        @else
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-6 image">
                                    <x-user.userImage role="admin"/>
                                    <div class="aktif"></div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-6 name ">
                                    @if (Auth::check())
                                        {{-- <span>{{ Str::substr(str_replace('admin', '', Auth::user()->name), 0, 9) }}</span> --}}
                                        <span class="overflow-auto">
                                            {{ getFirstName(Auth::user()->name) }}
                                        </span>
                                    @endif

                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3 col-sm-3 col-3 icon">
                        <span onclick="Logout()" class="material-symbols-outlined">
                            logout
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
