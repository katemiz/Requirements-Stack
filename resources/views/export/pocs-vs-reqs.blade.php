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

        <header class="my-6">
            <h1 class="title has-text-weight-light is-size-1">Proof of Compliances vs Requirements</h1>
            <h2 class="subtitle has-text-weight-light">Evidence / Proof of Compliances / Deliverables vs Requirement</h2>
        </header>


        @foreach ($matrix as $type => $type_reqs)
            

            <table class="table is-fullwidth">

                <thead>
                    <tr>
                        <th class="is-4">
                            Evidence Code<br>
                            Proof of Compliance
                        </th>

                        <th>
                            Requirements Binded to Proof of Compliance
                        </th>
                    </tr>
                </thead>

                <tbody>

                </tbody>


                @foreach ($matrix as $poc => $reqlist)
                <tr>
                    <td>
                        <strong>{{ $poc }}</strong><br>
                        {{ $pocnames[$poc] }}
                    </td>
                    <td>


                        <nav class="breadcrumb has-bullet-separator" aria-label="breadcrumbs">
                            <ul>

                                @foreach ($reqlist as $rrr)
                                <li><a href="#">{{ $rrr }}</a></li>
                                @endforeach

                            </ul>
                        </nav>
                    </td>
                </tr>
                    
                @endforeach

                <tbody>

            </table>


        @endforeach

    
    </section>
</body>
</html>
