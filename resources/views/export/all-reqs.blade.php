<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Engineering Toolkit</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/sweetalert2_min.css') }}">
    <script src="{{ asset('/js/sweetalert2.min.js') }}"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

</head>
<body>

    <section class="section container">

        @if ( count($allreqs) > 0)

            <header class="my-6">
                <h1 class="title has-text-weight-light is-size-1">General Requirements</h1>
                <h2 class="subtitle has-text-weight-light">Total number of requirements {{ count($allreqs['GR'])}}</h2>
            </header>

            @foreach ($allreqs['GR'] as $r)

                <div class="card mb-5 has-background-white-ter">

                    <div class="card-content">
                        <div class="media">

                            <div class="media-content">
                            <p class="title is-4">
                                <span>R{{$r->requirement_no}} R{{$r->revision}}</span>
                            </p>
                            </div>

                            <div class="media-content has-text-right">
                                <h4 class="subtitle has-text-weight-normal my-0">Applicable End Products</h4>

                                @foreach ($r->endproducts as $ep)
                                    <span class="tag is-dark">{{ $ep->title }}</span>
                                @endforeach

                            </div>
                        </div>

                        <div class="content">
                            {!! $r->text !!}

                            <table class="table is-fullwidth">
                            <caption>Requirement Verification Table</caption>

                            <tbody>
                            <tr>
                            <th>Decision Gate</th>
                            <th>MOC/Verification Method</th>
                            <th>Proof of Compliance</th>
                            <th>Witness</th>
                            </tr>

                            @foreach ($r->verifications as $verification)
                            <tr>
                            <td>{{ $verification->decision_gate}}</td>
                            <td>{{ $verification->moc_name}}</td>
                            <td>{{ $verification->poc_name}}</td>
                            <td>{{ $verification->witness_name}}</td>
                            </tr>
                            @endforeach

                            </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            @endforeach


            <header class="my-6">
                <h1 class="title has-text-weight-light is-size-1">Technical Requirements</h1>
                <h2 class="subtitle has-text-weight-light">Total number of requirements {{ count($allreqs['TR'])}}</h2>
            </header>


            @foreach ($allreqs['TR'] as $r)

                <div class="card mb-5 has-background-white-ter">

                    <div class="card-content">
                        <div class="media">

                            <div class="media-content">
                            <p class="title is-4">
                                <span>R{{$r->requirement_no}} R{{$r->revision}}</span>
                            </p>
                            </div>

                            {{-- <div class="media-content has-text-right">
                                <h4 class="subtitle has-text-weight-normal my-0">Applicable End Products</h4>

                                @foreach ($r->endproducts as $ep)
                                    <span class="tag is-dark">{{ $ep->title }}</span>
                                @endforeach

                            </div> --}}
                        </div>

                        <div class="content">
                            {!! $r->text !!}

                            <table class="table is-fullwidth">
                            <caption>Requirement Verification Table</caption>

                            <tbody>
                            <tr>
                            <th>Decision Gate</th>
                            <th>MOC/Verification Method</th>
                            <th>Proof of Compliance</th>
                            <th>Witness</th>
                            </tr>

                            @foreach ($r->verifications as $verification)
                            <tr>
                            <td>{{ $verification->decision_gate}}</td>
                            <td>{{ $verification->moc_name}}</td>
                            <td>{{ $verification->poc_name}}</td>
                            <td>{{ $verification->witness_name}}</td>
                            </tr>
                            @endforeach

                            </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            @endforeach




        @else

            <header class="my-6">
                <h1 class="title has-text-weight-light is-size-1">No Requirements</h1>
            </header>

        @endif


    </section>
</body>
</html>
