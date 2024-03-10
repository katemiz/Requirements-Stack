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

        @if (count($tests_vs_reqs_array) > 0)

            <header class="my-6">
                <h1 class="title has-text-weight-light is-size-1">Tests vs Requirements</h1>
                <h2 class="subtitle has-text-weight-light">Requirements Referred in Tests</h2>
            </header>

            <table class="table is-fullwidth">

                <thead>
                    <tr>
                        <th class="is-3 has-background-grey-lighter">Test</th>
                        <th class="has-background-grey-lighter">Requirement Number</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tests_array as $test)

                    <tr>
                        <td class="has-background-white-ter">
                            <strong>T{{ $test->test_no }} R{{ $test->revision }}</strong><br>
                            {{ $test->title }}
                        </td>

                        <td class="content">

                            @if ( isset($tests_vs_reqs_array[$test->id]) )

                                <ul>

                                @foreach ($tests_vs_reqs_array[$test->id] as $r)
                                <li>
                                    <a href="requirements/view/{{ $r->id }}" target="_blank">R{{ $r->requirement_no }} R{{ $r->revision }}</a>
                                </li>
                                @endforeach

                                </ul>

                            @else
                                <div class="notification is-danger is-light">No requirements linked to this test</div>
                            @endif

                            {{-- @if (isset($matrix[$dgate->id]))

                                <h2 class="subtitle has-text-info is-size-6">{{ count($matrix[$dgate->id]) }} POCS for this Decison Gate </h2>
                                @foreach ($matrix[$dgate->id] as $idPoc)
                                    <p>
                                    <strong>{{ $pocs[$idPoc]['code'] }}</strong> - {{ $pocs[$idPoc]['name'] }}
                                    </p>
                                @endforeach

                            @else
                            -
                            @endif --}}

                        </td>
                    </tr>
                    @endforeach
                <tbody>

            </table>

        @else
            <div class="notification is-link is-light">No requirements, no Decision Gate vs POCs</div>
        @endif

    </section>
</body>
</html>
