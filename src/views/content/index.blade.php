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
        <div
            class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
            <div class="w-full lg:w-5/6">
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Capabilities</th>
                                <th class="py-3 px-6 text-left">Currency</th>
                                <th class="py-3 px-6 text-center">Location</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">PAC TID</th>
                                <th class="py-3 px-6 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($getTerminals['data']['terminals'] as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="text-left">
                                            <!-- The button to open modal -->
                                            <label for="my-modal{{ $item['tpi'] }}" class="btn modal-button">
                                                Check Capabilities
                                            </label>

                                            <!-- Put this part before </body> tag -->
                                            <input type="checkbox" id="my-modal{{ $item['tpi'] }}"
                                                class="modal-toggle">
                                            <div class="modal">
                                                <div class="modal-box">
                                                    <div class="">
                                                        <h3 class="text-lg font-bold text-white">
                                                            Machine {{ $item['tpi'] }} Capabilities
                                                        </h3>
                                                        <table class="table table-zebra w-full">
                                                            <tbody>
                                                                @foreach ($item['capabilities'] as $itemList)
                                                                    <tr>
                                                                        <th class="text-white text-center">
                                                                            {{ $itemList }}
                                                                        </th>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-action">
                                                        <label for="my-modal{{ $item['tpi'] }}"
                                                            class="btn">Close</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <h3 class="font-semibold text-sm text-gray-400">
                                                {{ $item['currency'] }}
                                            </h3>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center">
                                            <p>{{ $item['location'] }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if ($item['status'] == 'AVAILABLE')
                                            <span
                                                class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Active</span>
                                        @else
                                            <span
                                                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="alert alert-info shadow-lg">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    class="stroke-current flex-shrink-0 w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <span>{{ $item['tpi'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">

                                        <!-- The button to open modal -->
                                        <label for="transaction{{ $item['tpi'] }}" class="btn modal-button">
                                            Start Transaction
                                        </label>
                                        <!-- Put this part before </body> tag -->
                                        <input type="checkbox" id="transaction{{ $item['tpi'] }}"
                                            class="modal-toggle">
                                        <div class="modal">
                                            <div class="modal-box relative">
                                                <label for="transaction{{ $item['tpi'] }}"
                                                    class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                                                <h3 class="text-lg font-bold text-white">Type the transaction
                                                    information</h3>
                                                <form action="{{ route('paymentSense.transaction-start') }}"
                                                        class="form-control w-full text-white"
                                                    method="POST">
                                                    @csrf
                                                    <div>
                                                        <label class="label">
                                                            <span class="label-text">Transaction Type</span>
                                                        </label>
                                                        <input type="text" placeholder="Type here"
                                                            name="transactionType" value="SALE"
                                                            class="input input-bordered input-primary w-full max-w-xs">
                                                        <label class="label">
                                                            <span class="label-text">Amount</span>
                                                        </label>
                                                        <input type="text" placeholder="Type here" name="amount"
                                                            value="100"
                                                            class="input input-bordered input-primary w-full max-w-xs">
                                                        <label class="label">
                                                            <span class="label-text">Amount Cashback</span>
                                                        </label>
                                                        <input type="text" placeholder="Type here" name="amountCashback"
                                                            value="50"
                                                            class="input input-bordered input-primary w-full max-w-xs">
                                                        <label class="label">
                                                            <span class="label-text">Currency</span>
                                                        </label>
                                                        <input type="text" placeholder="Type here" name="currency"
                                                            value="GBP"
                                                            class="input input-bordered input-primary w-full max-w-xs">
                                                        <input type="hidden" name="machine_id"
                                                            value="{{ $item['tpi'] }}">

                                                        <button class="btn btn-secondary w-full" type="submit">
                                                            Send
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Machine totals --}}
                                        <!-- The button to open modal -->
                                        <a href="{{ route('paymentSense.machine-total', $item['tpi']) }}"
                                            class="btn modal-button">Machine Totals</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
