<div class="card">
    <div class="card-header">
        <div class="col-6 float-left">
            <h4 style=" padding: 0.375rem 0;" class="m-0">{{ $title ?? '会員情報' }}</h4>
        </div>
    </div>
    <div class="card-body pb-5">
        <div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    ID
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->id }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    法人 / 屋号
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->company_name }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    担当者名
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->full_name }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    Eメールアドレス
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->email }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    事業形態
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->business_type_label }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    本社住所 郵便番号
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->zipcode }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    都道府県
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->prefecture }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    市区町村
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->city }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    番地・ビル名など
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->address }}
                </div>
            </div>
            <div class="row border-bottom {{ $form['row_class'] ?? '' }}">
                <div class="col-md-3 col-sm-12 p-2 d-flex align-items-center crud-label">
                    携帯電話番号
                </div>
                <div class="col-md-9 col-sm-12 p-2">
                    {{ $user->phone }}
                </div>
            </div>
        </div>
    </div>
</div>
