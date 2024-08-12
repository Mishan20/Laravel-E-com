<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel-Ecom Stripe Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #card-element {
            height: 50px;
            padding-top: 16px;
        }
    </style>
</head>

<body>

    <div class="container mx-auto">
        <div class="flex items-center justify-center h-screen">
            <div class="w-full max-w-md">
                <div class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md">
                    <h3 class="text-xl font-bold text-center">Laravel-Ecom Stripe Payment</h3>
                    <a href="{{url('/dashboard')}}" class="text-right text-blue-500 hover:text-blue-700">Back to Dashboard</a>

                    @if (session('success'))
                    <div class="relative px-4 py-3 mt-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @elseif (session('error'))
                    <div class="relative px-4 py-3 mt-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    <form id='checkout-form' method='post' action="{{ route('stripe.post') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                                Name:
                            </label>
                            <input type="text" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="name" placeholder="Enter Name">
                        </div>

                        <input type="hidden" name="total" value="{{ $total }}">
                        <input type="hidden" name='stripeToken' id='stripe-token-id'>

                        <div id="card-element" class="mb-4 form-control"></div>

                        <button
                            id='pay-btn'
                            class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                            type="button"
                            onclick="createToken()">PAY ${{ $total }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ config("services.stripe.pk") }}');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        function createToken() {
            document.getElementById("pay-btn").disabled = true;
            stripe.createToken(cardElement).then(function(result) {

                if (result.error) {
                    document.getElementById("pay-btn").disabled = false;
                    alert(result.error.message);
                } else {
                    document.getElementById("stripe-token-id").value = result.token.id;
                    document.getElementById('checkout-form').submit();
                }
            });
        }
    </script>

</body>

</html>