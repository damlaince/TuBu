<form action="{{$data['action']}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col mb-3">
            <h6>Kişi Bilgisi</h6>
            Adı Soyadı: {{$info->user->firstname}} {{$info->user->lastname}} <br>
            Kullanıcı Adı: {{$info->user->username}}<br>
            Telefon: {{$info->user->telephone}}<br>
            Email: {{$info->user->email}}
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col mb-3">
            <h6>Adres</h6>
            Ülke: {{$info->adress['country']}} <br>
            İl / İlçe: {{$info->adress['state']}} <br>
            Mahalle / Sokak: {{$info->adress['street']}} <br>
            No: {{$info->adress['no']}} <br>
            Posta Kodu: {{$info->adress['postcode']}}
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col mb-3">
            <h6>Ürün Bilgileri ({{count($info->product)}}) - {{$info->total_price}}₺</h6>
            @foreach($info->product as $product)
                ID: {{$product['product_id']}} <br>
                Sayı: {{$product['custom']}} <br>
                Beden: {{$product['size']}} <br>
                Fiyat: {{$product['price']}}₺ <br>
                Toplam Fiyat: {{$product['total_price']}}₺
            @endforeach
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col mb-3">
            <h6>Ödeme Bilgileri</h6>
            Kart Sahibi: {{$info->payment['fullname']}} <br>
            Kart No: {{$info->payment['card_no']}} <br>
            S.K.T: {{$info->payment['date_m']}}/{{$info->payment['date_y']}}<br>
            cvv: {{$info->payment['cvv']}}
        </div>
    </div>
    <hr>
    <div class="row g-1">
        <div class="col mb-3">
            <h6>Durum Güncelleme</h6>
            <select class="form-select" name="status">
                @foreach(Config::get('tubuset.order_status') as $key => $value)
                    <option value="{{$key}}" {{$info->status == $key ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>


    <br>
    <button type="submit" style="width: 100%" class="btn btn-primary btn-save">Kaydet</button>
</form>





