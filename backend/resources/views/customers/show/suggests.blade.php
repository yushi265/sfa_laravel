<div class="card col-sm ">
    <div class="card-body pb-2">
        <h4>提案</h4>
            <ul>
                @empty($customer->suggests)
                    <li>提案はありません<br>積極的に情報収集をしましょう！</li>
                @endempty
                @foreach ($customer->suggests as $suggest)
                    <li>{{ $suggest }}</li>
                @endforeach
            </ul>
    </div>
</div>
