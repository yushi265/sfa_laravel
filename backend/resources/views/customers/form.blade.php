{{-- 名前 --}}
<div class="row mb-3">
    <label for="inputName" class="col-sm-3 col-form-label">
        <span class="badge bg-primary">必須</span>
        名前
    </label>
    <div class="col-sm-9">
        <input type="text" name="name" class="form-control" id="inputName" placeholder="山田太郎"
            value="{{ $customer->name ?? old('name') }}">
    </div>
</div>

{{-- フリガナ --}}
<div class="row mb-3">
    <label for="inputRuby" class="col-sm-3 col-form-label">
        <span class="badge bg-primary">必須</span>
        フリガナ
    </label>
    <div class="col-sm-9">
        <input type="text" name="ruby" class="form-control" id="inputRuby" placeholder="ヤマダタロウ"
            value="{{ $customer->ruby ?? old('ruby') }}">
    </div>
</div>

{{-- 性別 --}}
<div class="row mb-3">
    <label for="inputPassword3" class="col-sm-3 col-form-label">
        <span class="badge bg-primary">必須</span>
        性別
    </label>
    <div class="col-sm-9">
        <select class="form-select" name="gender_id" aria-label="Default select example">
            <option selected>選択してください</option>
            @foreach (App\Gender::all() as $gender)
                <option value="{{ $gender->gender_id }}"
                    @isset($customer)
                        @if (old('gender_id', $customer->gender_id) == $gender->gender_id)
                            selected
                        @endif
                    @else
                        @if (old('gender_id') == $gender->gender_id)
                            selected
                        @endif
                    @endisset>
                    {{ $gender->name }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- 住所 --}}
<div class="row mb-3">
    <label for="inputAddress" class="col-sm-3 col-form-label">
        <span class="badge bg-primary">必須</span>
        住所
    </label>
    <div class="col-sm-9">
        <input type="text" name="address" class="form-control" id="inputAddress" placeholder="東京都新宿区新宿1"
            value="{{ $customer->address ?? old('address') }}">
    </div>
</div>

{{-- 生年月日 --}}
<div class="row mb-3">
    <label for="inputPassword3" class="col-sm-3 col-form-label">
        <span class="badge bg-primary">必須</span>
        生年月日
    </label>
    <div class="col-sm-3">
        <select class="form-select" name="birth[year]" aria-label="Default select example">
            <option selected>年</option>
            @for ($i = config('customers_form.max_year'); $i > config('customers_form.min_year'); $i--)
                <option value="{{ $i }}"
                    @isset($customer)
                        @if (old('birth.year', $customer->birth['year']) == $i)
                            selected
                        @endif
                    @else
                        @if (old('birth.year') == $i)
                            selected
                        @endif
                    @endisset
                >
                    {{ $i }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-sm-3">
        <select class="form-select" name="birth[month]" aria-label="Default select example">
            <option selected>月</option>
            @for ($i = config('customers_form.min_month'); $i <= config('customers_form.max_month'); $i++)
                <option value="{{ $i }}"
                    @isset($customer)
                        @if (old('birth.month', $customer->birth['month']) == $i)
                            selected
                        @endif
                    @else
                        @if (old('birth.month') == $i)
                            selected
                        @endif
                    @endisset>
                    {{ $i }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-sm-3">
        <select class="form-select" name="birth[day]" aria-label="Default select example">
            <option selected>日</option>
            @for ($i = config('customers_form.min_day'); $i <= config('customers_form.max_day'); $i++)
                <option value="{{ $i }}"
                    @isset($customer)
                        @if (old('birth.day', $customer->birth['day']) == $i)
                            selected
                        @endif
                    @else
                        @if (old('birth.day') == $i)
                            selected
                        @endif
                    @endisset>
                    {{ $i }}
                </option>
            @endfor
        </select>
    </div>
</div>

{{-- 電話番号 --}}
<div class="row mb-3">
    <label for="inputTell" class="col-sm-3 col-form-label">
        <span class="badge bg-primary">必須</span>
        電話番号
    </label>
    <div class="col-sm-9">
        <input type="text" name="tel" class="form-control" id="inputTell" placeholder="09012345678"
            value="{{ $customer->tel ?? old('tel') }}">
    </div>
</div>

{{-- メールアドレス --}}
<div class="row mb-3">
    <label for="inputMail" class="col-sm-3 col-form-label">
        <span class="badge bg-light text-dark">任意</span>
        メールアドレス
    </label>
    <div class="col-sm-9">
        <input type="text" name="mail" class="form-control" id="inputMail" placeholder="example@mail.com"
            value="{{ $customer->mail ?? old('mail') }}">
    </div>
</div>

{{-- 職業 --}}
<div class="row mb-3">
    <label for="inputPassword3" class="col-sm-3 col-form-label">
        <span class="badge bg-primary">必須</span>
        職業
    </label>
    <div class="col-sm-9">
        <select class="form-select" name="job_id" aria-label="Default select example">
            <option selected>選択してください</option>
            @foreach (App\Job::all() as $job)
                <option value="{{ $job->job_id }}"
                    @isset($customer)
                        @if (old('job_id', $customer->job_id) == $job->job_id)
                            selected
                        @endif
                    @else
                        @if (old('job_id') == $job->job_id )
                            selected
                        @endif
                    @endisset>
                    {{ $job->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- 勤務先 --}}
<div class="row mb-3">
    <label for="inputCompany" class="col-sm-3 col-form-label">
        <span class="badge bg-light text-dark">任意</span>
        勤務先
    </label>
    <div class="col-sm-9">
        <input type="text" name="company" class="form-control" id="inputCompany" placeholder="山田工業"
            value="{{ $customer->company ?? old('company') }}">
    </div>
</div>
