<form action="{{$data['action']}}" method="POST" id="category_form">
    @csrf
    <div class="row">
        <div class="col mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select required class="form-select" id="category" name="category">
                <option value="üst">Üst Kategori</option>
                @foreach($__categoriesüst->get() as $category)
                    <option value="{{$category->_id}}" {{isset($info->parent_id) && $info->parent_id == $category->id ? 'selected':''}}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row g-2">
        <div class="col mb-3">
            <label for="name" class="form-label">Kategori Adı</label>
            <input required type="text" id="name" class="form-control" name="category_name"
                   value="{{isset($info->name) && $info->name ? $info->name : ''}}"/>
        </div>
    </div>
    <div class="row g-2">
        <div class="form-check form-switch mb-2">
            <label class="form-check-label" for="status"
            >Durum</label
            >
            <input class="form-check-input" type="checkbox" name="category_status"
                   id="status" {{isset($info->status) && $info->status ? 'checked' : ''}}/>
        </div>
    </div>
    <br>
    <button type="submit" style="width: 100%" class="btn btn-primary btn-save">Kaydet</button>
</form>




