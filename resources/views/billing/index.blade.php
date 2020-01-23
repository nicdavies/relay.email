@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 py-3">
        <h2 class="h3 font-w700 mb-2">Billing</h2>
        <h3 class="h5 font-w400 text-muted">Manage your subscription!</h3>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="content mb-7">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="block block-rounded border-top border-3x border-success">
                    <div class="block-header">
                        <h3 class="block-title">Overview</h3>

                        <div class="block-options">
                            @if ($user->subscribed() && !$user->subscription()->cancelled())
                                <form action="{{ route('billing.subscription.cancel') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-hero-sm">
                                        Cancel
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('billing.subscription.start') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-hero-info btn-hero-sm">
                                        Subscribe To Premium
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="block-content border-top">
                        <p>
                            <strong>Current Plan:</strong>

                            @if ($user->subscribed())
                                <span class="badge badge-info">
                                    {{ $user->subscription()->stripe_plan }}
                                </span>

                                @if ($user->subscription()->onTrial())
                                    <span class="badge badge-warning ml-1">
                                        On Trial
                                    </span>
                                @endif

                                @if ($user->subscription()->cancelled())
                                    <span class="badge badge-danger ml-1">
                                        Cancelled
                                    </span>
                                @endif
                            @else
                                <span>FREE / $0 <small>per month</small></span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Credit Card</h3>

                        @if ($user->hasPaymentMethod())
                            <div class="block-options">
                                <div class="block-options-item font-italic">
                                    {{ $user->card_brand }} ********{{ $user->card_last_four }}
                                </div>

                                <form class="block-options-item" action="{{ route('billing.card.destroy') }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-block-option text-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if (! $user->hasPaymentMethod())
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-lg-12 ml-auto">
                                    <label for="example-text-input">Cardholder Name</label>
                                    <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" placeholder="Cardholder Name">
                                </div>
                            </div>

                            <div class="form-group row pt-3">
                                <div class="col-lg-12 ml-auto">
                                    {{-- STRIPE CARD ELEMENT INSERTED HERE --}}
                                    <div id="card-element"></div>
                                    <div id="card-errors" class="text-danger" role="alert"></div>
                                </div>
                            </div>

                            <div class="form-group pt-3">
                                <button type="submit" id="card-submit" class="btn btn-hero-success" data-secret="{{ $intent->client_secret }}">
                                    Save
                                </button>
                            </div>

                            <form action="{{ route('billing.card.store') }}" method="post" id="card-submit-form">
                                @csrf
                                <input type="hidden" id="stripe_token" name="stripe_token">
                            </form>
                        </div>
                    @endif
                </div>

                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Invoices</h3>
                    </div>

                    <div class="block-content-full border-top">
                        <table class="table table-vcenter">
                            <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
{{--                                <th class="text-center" style="width: 100px;">Actions</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->invoices() as $invoice)
                                    <tr>
                                        <th>{{ $invoice->date()->toFormattedDateString() }}</th>
                                        <td>{{ $invoice->total() }}</td>
{{--                                        <td class="text-center">--}}
{{--                                            <div class="btn-group">--}}
{{--                                                <a href="{{ route('billing.invoice', $invoice->id) }}" class="btn btn-rounded btn-sm btn-secondary">--}}
{{--                                                    Download--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('cardholder_name');
        const cardButton = document.getElementById('card-submit');
        const clientSecret = cardButton.dataset.secret;
        const cardSubmitForm = document.getElementById('card-submit-form');

        cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
                // Display "error.message" to the user...
            } else {
                const inputElement = document.getElementById('stripe_token');
                inputElement.value = setupIntent.payment_method;

                cardSubmitForm.submit();
            }
        });
    </script>
@endsection
