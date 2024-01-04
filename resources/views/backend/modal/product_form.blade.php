<form action="{{$data['action']}}" method="POST" id="category_form" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col mb-3">
            <label for="categorylist" class="form-label">Kategori</label>
            <select class="form-select" required
                    id="categorylist" name="category_id">
                <option value=""></option>
                @foreach($__categoriesüst->get() as $categoryüst)
                    <optgroup label="{{$categoryüst->name}}">
                        @if($categoryüst->childs)
                            @foreach($categoryüst->childs as $categoryalt)
                                <option value="{{$categoryalt->_id}}" {{isset($info->category_id) && $info->category_id == $categoryalt->_id? "selected" : ''}}>{{$categoryalt->name}}</option>
                            @endforeach
                        @endif
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="product_name" class="form-label">Ürün Adı</label>
            <input required type="text" class="form-control" name="name"
                   value="{{isset($info->name) && $info->name ? $info->name : ''}}">
        </div>
    </div>
    <div class="row g-2">
        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <label for="html5-color-input" class="col-md-2 col-form-label">Renk</label>
            <div class="col">
                <input required class="form-control" name="color" type="color"
                       value="{{isset($info->color) && $info->color ? $info->color : '#666EE8'}}"
                       id="html5-color-input"/>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <label for="sizelist" class="form-label">Bedenler</label>
            <select required size="1" class="js-example-basic-multiple form-select" id="sizelist" name="sizes[]"
                    multiple="multiple">
                <option value="all">Tümü</option>
                @foreach(\Illuminate\Support\Facades\Config::get('tubuset.sizes') as $size)
                    <option
                        value="{{$size}}" {{isset($info->sizes) && in_array($size, $info->sizes) ? 'selected':''}}>{{$size}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row g-2">
        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <label for="custom" class="form-label">Adet</label>
            <input required type="number" class="form-control" id="custom" name="custom"
                   value="{{isset($info->custom) && $info->custom ? $info->custom : 0}}">
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <label for="price" class="form-label">Fiyat</label>
            <div class="input-group input-group-merge">
                <span class="input-group-text">₺</span>
                <input required
                       type="number" value="{{isset($info->price) && $info->price ? $info->price : 0}}"
                       class="form-control"
                       name="price"
                       placeholder="100"
                       aria-label="Amount (to the nearest dollar)"
                />
                <span class="input-group-text">.00</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <div class="input-group">
                <input type="file" name="product_images[]" class="form-control" multiple/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <div class="input-group mb-3">
                <span class="input-group-text">Açıklama</span>
                <textarea name="description" class="form-control"
                          aria-label="With textarea">{{isset($info->description) && $info->description ? $info->description : ''}}</textarea>
            </div>
        </div>
    </div>
    <div class="row g-2">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="gender" class="form-label">Cinsiyet</label>
            <select required class="form-select" id="gender" name="gender">
                <option value=""></option>
                @foreach(\Illuminate\Support\Facades\Config::get('tubuset.gender') as $key => $gender)
                    <option value="{{$key}}" {{isset($info->gender) && $info->gender == $key ? 'selected':''}}>{{$gender}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="form-check form-switch mb-2">
                <label class="form-label" for="status"
                >Durum</label
                >
                <input class="form-check-input" type="checkbox" name="status"
                       id="status" {{isset($info->status) && $info->status ? 'checked' : ''}}/>
            </div>
        </div>
    </div>
    <br>
    @if(isset($data['error']))
        @php
            $error = '';
            if (isset($data['error']['category_id'])) {
                $error = $data['error']['category_id'][0];
            } else if (isset($data['error']['name'])) {
                $error = $data['error']['name'][0];
            } else if (isset($data['error']['sizes'])) {
                $error = $data['error']['sizes'][0];
            }
        @endphp
        <div class="alert alert-primary" role="alert">{{$error}}</div>
    @endif
    <br>
    <button type="submit" style="width: 100%" class="btn btn-primary btn-save">Kaydet</button>
</form>





