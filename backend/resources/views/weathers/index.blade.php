@extends('layouts.app')

@section('content')

@php
    date_default_timezone_set('Asia/Tokyo');
@endphp

<div class="container">

    <h4 class="mb-4">千葉県の天気予報</h4>
    {{-- 5時間天気 --}}
    <div class="row">
        <div class="col-md-6">
            <p>5時間後までの天気</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ date('n/j')}}</th>
                        <th scope="col">気温</th>
                        <th scope="col">天気</th>
                        <th scope="col">降水確率</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hourly_weathers as $weather)
                    <tr>
                        <th scope="row">{{ date('H:i', $weather['dt'])}}</th>
                        <td>{{ $weather['temp'] }}℃</td>
                        <td>{{ $weather['weather'][0]['description'] }}</td>
                        <td>{{ $weather['pop'] * 100 .'%' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- 1週間天気 --}}
        <div class="col-md-6">
            <p>1週間天気予報</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">日</th>
                        <th scope="col">気温</th>
                        <th scope="col">天気</th>
                        <th scope="col">降水確率</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daily_weathers as $weather)
                    <tr>
                        <th scope="row">
                            {{ date('n/j', $weather['dt']) }}
                            @switch(date('w', $weather['dt']))
                                @case(0)
                                    （日）
                                    @break
                                @case(1)
                                    （月）
                                    @break
                                @case(2)
                                    （火）
                                    @break
                                @case(3)
                                    （水）
                                    @break
                                @case(4)
                                    （木）
                                    @break
                                @case(5)
                                    （金）
                                    @break
                                @case(6)
                                    （土）
                                    @break
                                @default
                            @endswitch
                        </th>
                        <td>{{ $weather['temp']['day'] }}℃</td>
                        <td>{{ $weather['weather'][0]['description'] }}</td>
                        <td>{{ $weather['pop'] * 100 . '%' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <p class="mt-5 text-right">(OpenWeather)</p>
</div>
    @endsection
