<div class="card m-1 mb-2">
    <div class="card-body row">
        <div class="col-sm-6">
            <input type="text" class="form-control" placeholder="キーワードを入力" name="search"
                    aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ $request->search }}">
        </div>
        <div class="col-sm-6">
            <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">
                詳細条件
            </button>
            <button class="btn btn-outline-primary" type="submit" id="button-addon2">検索</button>
            <a href="{{ route('customers.index') }}" type='button' class="btn btn-outline-secondary">リセット</a>
        </div>
    </div>
</div>

<div class="collapse col-md-6" id="collapseExample">
                <div class="card card-body">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="gender_opt">性別</label>
                        <select class="form-select" name="gender_opt" id="gender_opt">
                            <option value="" selected>指定しない</option>
                            @foreach (App\Gender::all() as $gender)
                                <option value="{{ $gender->gender_id }}" @if ($request->gender_opt == $gender->gender_id) selected @endif>
                                    {{ $gender->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="job_opt">職業</label>
                        <select class="form-select" name="job_opt" id="job_opt">
                            <option value="">指定しない</option>
                            @foreach (App\Job::all() as $job)
                                <option value="{{ $job->job_id }}" @if ($request->job_opt == $job->job_id) selected @endif>
                                    {{ $job->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">年齢</span>
                        </div>
                        <input type="text" name="min_age" class="form-control"
                            value="{{ old('min_age', $request->min_age) ?? 0 }}">
                        <div class="input-group-prepend">
                            <span class="input-group-text">〜</span>
                        </div>
                        <input type="text" name="max_age" class="form-control"
                            value="{{ old('max_age', $request->max_age) ?? 120 }}">
                    </div>
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">検索</button>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger col-md-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
