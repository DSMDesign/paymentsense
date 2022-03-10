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
                    <h1>Transaction status:
                        <div class="badge badge-primary">{{ $getTransactionInformation['data']['notifications'][0] }}
                        </div>
                    </h1>
                    <div class="overflow-x-auto">
                        <div class="hero min-h-screen bg-base-200">
                            <div class="hero-content text-center">
                                <div class="w-full">
                                    <h1 class="text-5xl font-bold">Transaction information</h1>
                                    <table class="table table-compact w-full">
                                        <tbody>
                                            @foreach ($getTransactionInformation['data'] as $key => $item)
                                                @if (!is_array($item))
                                                    <tr>
                                                        <th>{{ $key }}:</th>
                                                        <th>{!! $item !!}</th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="hero min-h-screen bg-base-200">
                            <div class="hero-content text-center">
                                <div class="w-full">
                                    <h1 class="text-5xl font-bold">Notification Information</h1>
                                    <table class="table table-compact w-full">
                                        <tbody>
                                            @foreach ($getTransactionInformation['data']['notifications'] as $key => $item)
                                                @if (!is_array($item))
                                                    <tr>
                                                        <th>{{ $key }}:</th>
                                                        <th>{!! $item !!}</th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- {{ dd($getTransactionInformation['data']['receiptLines']) }} --}}
                    <a class="btn btn-error"
                        href="{{ route('paymentSense.transaction-cancel', [
                            'requestId' => $requestId,
                            'machineId' => $machineId,
                        ]) }}">Cancel
                        Transaction</a>
                    <a class="btn btn-info" href="{{ route('paymentSense.demo') }}">Return</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
