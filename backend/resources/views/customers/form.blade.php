    {{-- 名前 --}}
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-3 col-form-label">
            <span class="badge bg-primary">必須</span>
            名前
        </label>
        <div class="col-sm-9">
            <input type="text" name="name" class="form-control" id="inputEmail3"
                value="{{ $customer->name ?? old('name') }}">
        </div>
    </div>

    {{-- フリガナ --}}
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-3 col-form-label">
            <span class="badge bg-primary">必須</span>
            フリガナ
        </label>
        <div class="col-sm-9">
            <input type="text" name="ruby" class="form-control" id="inputPassword3"
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
                @foreach ($genders as $gender)
                    <option value="{{ $gender->gender_id }}" @if (old('gender_id') == $gender->gender_id) selected @endif>
                        {{ $gender->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- 住所 --}}
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-3 col-form-label">
            <span class="badge bg-primary">必須</span>
            住所
        </label>
        <div class="col-sm-9">
            <input type="text" name="address" class="form-control" id="inputPassword3"
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
            <select class="form-select" aria-label="Default select example">
                <option selected>年</option>
                @for ($i = 2021; $i > 1900; $i--)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="col-sm-3">
            <select class="form-select" aria-label="Default select example">
                <option selected>月</option>
                <option value="1">One</option>
                <option value="3">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
        <div class="col-sm-3">
            <select class="form-select" aria-label="Default select example">
                <option selected>日</option>
                <option value="1">One</option>
                <option value="3">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
    </div>

    {{-- 電話番号 --}}
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-3 col-form-label">
            <span class="badge bg-primary">必須</span>
            電話番号
        </label>
        <div class="col-sm-9">
            <input type="text" name="tel" class="form-control" id="inputPassword3"
                value="{{ $customer->tel ?? old('tel') }}">
        </div>
    </div>

    {{-- メールアドレス --}}
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-3 col-form-label">
            <span class="badge bg-light text-dark">任意</span>
            メールアドレス
        </label>
        <div class="col-sm-9">
            <input type="text" name="mail" class="form-control" id="inputPassword3"
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
                @foreach ($jobs as $job)
                    <option value="{{ $job->job_id }}" @if (old('job_id') == $job->job_id) selected @endif>{{ $job->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- 勤務先 --}}
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-3 col-form-label">
            <span class="badge bg-light text-dark">任意</span>
            勤務先
        </label>
        <div class="col-sm-9">
            <input type="text" name="company" class="form-control" id="inputPassword3"
                value="{{ $customer->company ?? old('company') }}">
        </div>
    </div>
