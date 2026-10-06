@props([
        'type' => 'danger',
        'kelurahan' => 'Kelurahan Bukit datuk',
        'type_detail' => 'Meminta pengajuan pergantian kontainer',
        'action' => 'enable',
        'notifikasi' => '',
        'id' => '0'
    ])

@if ($type === 'danger')
    @php
        $bg = 'bg-transparent-danger';
        $color = 'color-notifikasi-danger';
    @endphp
@elseif ($type === 'warning')
    @php
        $bg = 'bg-transparent-warning';
        $color = 'color-notifikasi-warning';
    @endphp
@else
    @php
        $bg = 'bg-transparent-success';
        $color = 'color-notifikasi-success';
    @endphp
@endif

<div class="notifikasi-wrapper {{ $bg }}">
    <div class="icon">
        <span class="material-symbols-outlined {{ $color }}">
            @if ($type == 'danger')
                error
            @elseif ($type == 'warning')
                warning
            @else
                check
            @endif
        </span>
    </div>
    <div class="detail" title="{{ ($notifikasi === '') ? $kelurahan : $notifikasi }}">
        <div class="top">
            @if ($notifikasi === '')
                {{ $kelurahan }}
            @else
                {{ limitNameOfRegion($notifikasi) }}
            @endif
        </div>
        <div class="bottom">
            {{ $type_detail }}
        </div>
    </div>
    @if ($action === "enable")
        <div class="action">
            <form action="" id="updatePermintaanKontainer" method="POST">
                @csrf
                @method('PUT')
            </form>
            <a onclick="event.preventDefault(); updatePermintaanKontainer('{{ route('kontainer.updatePermintaan', ['id' => $id]) }}')" href="#" class="link-dark" id="hrefUpdateKontainer">
                @if ($type == 'danger')
                    Ganti kontainer
                @elseif ($type == 'warning')
                    Cek kontainer
                @else
                    <span class="material-symbols-outlined">
                        close
                    </span>
                @endif
            </a>
        </div>
    @endif
</div>
