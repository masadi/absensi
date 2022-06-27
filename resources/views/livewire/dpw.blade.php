<div>
    <div>
        <x-jet-label class="form-label" for="dpw" value="Keanggotaan tergabung di Peradaban DPW" />
        <select class="form-control select2" wire:model="dpw" id="dpw">
            <option value="{{$dpw}}">{{ ($dpw) ? $selected->name : 'Please select' }}</option>
        </select>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            //Livewire.emit('updateProfileInformation')
            $('.select2').select2({
                ajax: {
                    url: "/api/cari-dpw",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
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
                placeholder: 'Cari nama DPW',
                minimumInputLength: 3,
                //templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            function formatRepoSelection (data) {
                return data.text;
            }
            $('#dpw').on('change', function (e) {
                //console.log('select2');
                var data = $(this).val();
                console.log($(this).val());
                @this.set('dpw', data);
            });
        })
    </script>
</div>
@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script>
    var picker = new Pikaday({
    // just showing the format option
    format: 'DD-MM-YYYY'
    });
</script>
@endsection
@section('page-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endsection