<div class="modal-header-custom p-4" style="border-bottom: 1px solid #dee2e6;">
    <div class="d-flex flex-row justify-content-between align-items-end">
        <h4 class="modal-title" id="modal-default-label">{{ $masterCategory == null ? "Form Tambah"  : "Form Update"}}</h4>
        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
    </div>
</div>

<div class="modal-body">
    <form action="{{ url("master-category/save",[$masterCategory?->id ?? 0]) }}" method="POST" enctype="multipart/form-data" id="form_validation">
        <div class="row mb-3">
            <label for="input_parent" class="col-sm-12 col-md-12 col-form-label">Kategori Induk</label>
            <div class="col-sm-12 col-md-12">
                <div class="d-flex flex-column">
                    <div class="combobox-container">
                        <select class="form-select select2-custom" name="input_parent">
                            <option value="">Pilih Induk</option>
                            @foreach($masterCategoryParents as $key => $value)
                                <option value="{{$value?->id}}" {{ ($masterCategory?->categoryParent?->id == $value?->id ? "selected" : "")}}>{{$value?->name ?? ""}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_name" class="col-sm-12 col-md-12 col-form-label">Nama</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input_name" class="form-control" id="input_name" value="{{$masterCategory?->name}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_code" class="col-sm-12 col-md-12 col-form-label">Kode</label>
            <div class="col-sm-12 col-md-12">
                <input type="text" name="input_code" class="form-control" id="input_code" value="{{$masterCategory?->code}}" required >
            </div>
        </div>

        <div class="row mb-3">
            <label for="input_description" class="col-sm-12 col-md-12 col-form-label">Deskripsi</label>
            <div class="col-sm-12 col-md-12">
                <textarea name="input_description" id="input_description" class="form-control" rows="3" required>{{$masterCategory?->description}}</textarea>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <label for="input_status" class="col-sm-12 col-md-12 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10 ">
                <div class="d-flex flex-column">
                    <div class="radio-container">
                        @foreach($statuses as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="input_status" id="input-radio-{{$key}}" value="{{$key}}" {{ ($masterCategory?->status ?? 'active') == $key ? "checked" : ""}}>
                                <label class="form-check-label" for="input-radio-{{$key}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @csrf
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
        <i class="bx bx-x d-block d-sm-none"></i>
        <span class="d-sm-block d-none">Close</span>
    </button>
    <button type="submit" class="btn btn-primary" name="btn-submit" form="form_validation">
        <i class="bx bx-check d-block d-sm-none"></i>
        <span class="d-sm-block d-none">Submit</span>
    </button>
</div>

<script type="text/javascript">
    $(document).ready(function(e){
        $("#form_validation").validate({
            rules : {
            },
            messages : {
            }
        });

        $('#form_validation').on('submit',function(e){
            e.preventDefault();
            const form = $(this);
            if(!form.valid()) return false;

            let data = new FormData(form[0]);
            let url = `{{ url("master-category/save",[$masterCategory?->id ?? 0]) }}`;
            $.ajax({
                url : url,
                method : 'POST',
                data : data,
                processData: false,
                contentType: false,
                success : function(data){
                    let modal = $("#modal-default");
                    modal.modal('hide');
                    location.reload();
                }
            }).fail(function(xhr,textStatus){
                console.log("XHR Fail Console", xhr);
                let errors = xhr.responseJSON?.errors ?? xhr.responseJSON?.message ?? "Terjadi masalah, coba beberapa saat lagi";
                showErrorsOnModal(errors);
            }).done(function(xhr,textStatus){
                console.log("done : ",xhr);
            });
        })
    });
</script>
