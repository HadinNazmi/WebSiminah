@props(['id' => '','class' => 'tableForPagination'])

<div class="table-responsive-sm table-responsive-xl table-responsive-lg table-responsive-md">
    <table id="{{ $id }}" data-id="{{ $id }}"
        class="{{ $class }} table align-middle mb-0 reward-table ps-6">
        <thead>
            <tr>
                {{ $headSlot }}
            </tr>
        </thead>
        <tbody>
            {{ $bodySlot }}
        </tbody>
    </table>
</div>


