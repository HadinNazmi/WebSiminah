@props(['value' => ''])

<div class="radio-wrapper d-flex">
    <div class="left-side">
        <input type="radio" name="is_kecamatan" id="isKecamatanTrue" value="1"
            @if (empty($value)) selected
        @else
            @if ($value === 1)
                selected
            @else 
                not selected
            @endif
            @endif>
        <label for="isKecamatanTrue">Kecamatan</label>
    </div>
    <div class="right-side">
        <input type="radio" name="is_kecamatan" id="isKecamatanFalse" value="0" @if ($value === 0)
        selected
    @endif>
        <label for="isKecamatanFalse">Kelurahan</label>
    </div>
</div>


<script>
    const defaultChecked = document.querySelector('#isKecamatanTrue');
    defaultChecked.checked = true;
</script>
