@extends('layout')

@section('content')
    <div class="container mt-2">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Well done!</h4>
            <p>Your SID = {{ session('oauth_user')['sid'] }}</p>
        </div>

        <div id="accordion">
            @foreach($currencies as $currency)
                <div class="card">
                    <div class="card-header" id="currency{{ $currency['curr_code'] }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#currencyCollapse{{ $currency['curr_code'] }}" aria-expanded="true" aria-controls="collapseOne">
                                {{ $currency['curr_code'] }}
                            </button>
                        </h5>
                    </div>

                    <div id="currencyCollapse{{ $currency['curr_code'] }}" class="collapse" aria-labelledby="currency{{ $currency['curr_code'] }}" data-parent="#accordion">
                        <div class="card-body">
                            <ul>
                            @foreach($rates as $rate)
                                <li>
                                    From = {{ $rate['from'] }} <br />
                                    Rate = {{ $rate['rate'] }} <br />
                                    To = {{ $rate['to'] }} <br />
                                    Version = {{ $rate['version'] }}
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection