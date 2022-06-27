<div>
    <div wire:ignore.self>
        <x-jet-label class="form-label" for="{{$select_id}}" value="{{$title}}" />
        <select class="form-control select2 {{ $errors->has($select_id) ? 'is-invalid' : '' }}" id="{{$select_id}}" wire:model.lazy="{{$model}}">
            <option value="{{$value}}">{{$placeholder}}</option>
        </select>
        <x-jet-input-error for="{{$select_id}}" />
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            $('#{{$select_id}}').select2({
                dropdownParent: $('#{{$modalId}}'),
                ajax: {
                    url: "{{$url}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results.data,
                        pagination: {
                            more: (params.page * 10) < data.results.total
                        }
                    };
                    },
                    cache: true
                },
                placeholder: '{{$placeholder}}',
                minimumInputLength: 3,
                templateSelection: formatRepoSelection,
                language: {
                    errorLoading:function(){
                        return"Data tidak boleh diambil."
                    },
                    inputTooLong:function(n){
                        return"Hapuskan "+(n.input.length-n.maximum)+" huruf"
                    },
                    inputTooShort:function(n){
                        return"Masukkan "+(n.minimum-n.input.length)+" huruf lagi"
                    },
                    loadingMore:function(){
                        return"Mengambil data..."
                    },
                    maximumSelected:function(n){
                        return"Anda hanya dapat memilih "+n.maximum+" pilihan"
                    },
                    noResults:function(){
                        return"Tidak ada data yang sesuai"
                    },
                    searching:function(){
                        return"Mencari..."
                    },
                    removeAllItems:function(){
                        return"Hapus semua item"
                    }
                }
            });
            function formatRepoSelection (data) {
                return data.text
            }
            $('#{{$select_id}}').on('change', function (e) {
                //console.log('select2');
                //var data = $('#select2-dropdown').select2("key");
                console.log($(this).val());
                
                Livewire.emit('{{$model}}', $(this).val())
            });
        })
    </script>
</div>