@extends('components._partials.default')

@section('content')

    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-xxl-11 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12 reward text-poppins">
                        Admin Kelurahan
                    </div>
                </div>
                <div class="row reedem-reward animate__animated animate__fadeInUp">
                    <div class="col-md-10 col-sm-10 col-10">
                        <div class="table-header-redeem">
                            Daftar Admin
                        </div>
                    </div>
                    <div
                        class="col-md-2 col-sm-2 col-2 text-poppins text-14 btn-reward-position d-flex justify-content-end align-items-end">
                        <div>
                            <a href="{{ route('admin.create') }}"
                                class="btn-reward btn-custom-success position-relative">Tambah</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <x-forms.table id="tabel-index-admin">
                            @slot('headSlot')
                                <th class="text-semi-dark">NAMA ADMIN</th>
                                <th class="text-semi-dark">EMAIL</th>
                                <th class="text-semi-dark">NO TELEPON</th>
                                <th class="text-semi-dark">ALAMAT</th>
                                <th class="text-semi-dark">AKSI</th>
                            @endslot

                            @slot('bodySlot')
                                {{-- {{ dd($user) }} --}}
                                @if (!empty($user))
                                    @foreach ($user as $item)
                                        <tr class="reward-row table-row-image">
                                            <td class="ps-4 admin-row">
                                                <span class="top">{{ $item->name }}</span><br>
                                                <span class="bottom">{{ $item->nama_kelurahan }}</span>
                                            </td>
                                            <td class="ps-4 text-semi-dark text-inter-regular text-14">
                                                {{ $item->email }}
                                            </td>
                                            <td class="ps-4 text-semi-dark text-inter-regular text-14">
                                                {{ $item->no_hp }}
                                            </td>
                                            <td class="ps-4 text-semi-dark-68 text-inter-regular text-14">
                                                {{ limitAlamatLength($item->alamat_rumah) }}
                                            </td>
                                            <td>
                                                <div class="btn-reward btn-list position-relative">
                                                    <a href="{{ route('admin.edit', ['id' => $item->id_user]) }}" class="position-relative add-reward">EDIT
                                                    </a>
                                                </div>
                                                {{-- &nbsp;&nbsp;&nbsp;
                                                <div class="btn-reward btn-list btn-custom-danger position-relative">
                                                    <a href="#" class="position-relative add-reward"
                                                        onclick="deleteRecord('{{ route('admin.destroy', ['id' => $item->id_admin_kelurahan]) }}')">DELETE</a>
                                                </div> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endslot
                        </x-forms.table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Forms --}}
    <form id="formDeleteAdmin" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('script')
    <script>
        const dataId = $('.tableForPagination').data('id')
        pagination(dataId)
    </script>
@endsection

