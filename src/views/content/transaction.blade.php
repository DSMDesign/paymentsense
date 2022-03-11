<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.6.3/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body data-theme="dark">
    <div class="overflow-x-auto">
        <div class="min-w-screen min-h-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="card w-full bg-neutral text-neutral-content">
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Transaction successfully created</h2>
                    <p>Transaction information.</p>

                    <div class="overflow-x-auto">
                        <table class="table table-compact w-full">
                            <tbody>
                                <tr>
                                    <th>Location:</th>
                                    <th>{{ $transactionInformation['data']['location'] }}</th>
                                </tr>
                                <tr>
                                    <th>Request id:</th>
                                    <th>{{ $transactionInformation['data']['requestId'] }}</th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <a class="btn btn-active btn-primary"
                        href="{{ route('paymentSense.transaction-information', [
                            'requestId' => $transactionInformation['data']['requestId'],
                            'machineId' => $machineId
                        ]) }}">
                        Check Transaction Information
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
