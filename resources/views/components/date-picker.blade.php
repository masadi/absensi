<div x-data="" x-on:change="value = $event.target.value" x-init=" new Pikaday({ field: $refs.input, 'format': 'DD-MM-YYYY', });" class="sm:w-27rem sm:w-full">
    <input x-ref="input" type="text" class="form-control" placeholder="Pilih Tanggal" />
</div>
