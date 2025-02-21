@extends('layouts.master_open_header')
@section('content')
<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
            Checkout
        </h1>
    </div>
</section>
<form method="post" action="{{ route('student.booking.checkout.update') }}" data-cc-on-file="false" data-stripe-publishable-key="{{  config('services.stripe.key')  }}" role="form" id="payment-form" class="require-validation">
    @csrf
    <input type='hidden' name='task' value="checkout"> 
    <input type='hidden' name='booking_id' value="{{$booking->_id}}"> 
    <input type='hidden' name='user_id' value="{{$user->_id}}"> 
    <input type='hidden' name='stripeToken' id="payment-method-id" value=""/>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">
                    <div class="widget-label">
                        <h3>
                            Course Details
                        </h3>
                        <h1>
                            {{$booking->classes->title}}
                        </h1>
                    </div>
                </div>
                
                <div class="field">
                    <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <p>Selected time : {{$booking->classdate->class_date}} {{$booking->classdate->start_at}} to {{$booking->classdate->end_at}}</p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="field">
                    <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <p> {{$booking->classes->description}}</p>
                            <p> {{$booking->classes->instructor->name}}</p>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">Name</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input type="text" autocomplete="on" name="name" value="{{$user->name}}" class="input" required autocomplete='off' disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">Email</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input type="text" autocomplete="on" name="email" value="{{$user->email}}" class="input" required autocomplete='off' disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">Phone</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input type="text" autocomplete="on" name="phone" value="{{$user->phone}}" class="input" required autocomplete='off' disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">
                    <div class="widget-label">
                        <h3>
                            Payment Details
                        </h3>
                        <h1>
                            &nbsp;
                        </h1>
                    </div>
                </div>
                <div class="field">
                <label class="label">Amount</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input type="text" autocomplete="on" name="amountShow" value="{{ $charge }}" class="input" required disabled>
                                <input type="hidden" autocomplete="on" name="amount" value="{{ $charge }}" class="input">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">Name on Card</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input  type="text" autocomplete="on" name="cardholderName"  class="input" autocomplete='off' required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">Card Number</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <!-- <input id="cardNumber" autocomplete="off" placeholder="XXXX XXXX XXXX XXXX" class="input card-number" maxlength="19" name="cardNumber" type="text"> -->
                                <div id="card-element" class="input" name="cardNumber"></div>
                            </div>
                            <p class="help">Required. XXXX XXXX XXXX XXXX</p>
                        </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">CVC</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input id="ccvNumber" type="text" autocomplete="off" name="cvc" placeholder="ex. 311" class="input card-cvc" maxlength="3" required>
                            </div>
                            <p class="help">Required. ex. 311</p>
                        </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">Expiration Month</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input type="text" autocomplete="off" name="expMonth" placeholder="MM" class="input card-expiry-month" size='2' required>
                            </div>
                            <p class="help">Required.</p>
                        </div>
                    </div>
                </div>
                <div class="field">
                <label class="label">Expiration Year</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input type="text" autocomplete="off" name="expYear" placeholder="YYYY" class="input card-expiry-year" size='4' required>
                            </div>
                            <p class="help">Required.</p>
                        </div>
                    </div>
                </div>
                <div class="field error hidden alert alert-error">
                    <div class="label alert-danger alert">Please correct the errors and try again.</div>
                </div>
                <hr>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button green">
                            Pay now
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var stripe = Stripe("{{ config('services.stripe.key') }}"); // Your Stripe Publishable Key
        var elements = stripe.elements();

        // Create a Card Element
        var card = elements.create("card", {
            hidePostalCode: true,
            style: {
                base: {
                    fontSize: "16px",
                    color: "#32325d",
                    fontFamily: "Arial, sans-serif",
                    "::placeholder": { color: "#aab7c4" }
                },
                invalid: { color: "#fa755a" }
            }
        });

        // Mount the Card Element inside the div
        card.mount("#card-element");

        var form = document.getElementById("payment-form");
        var submitButton = form.querySelector("button[type='submit']");

        form.addEventListener("submit", async function (event) {
            event.preventDefault();
            submitButton.disabled = true; // Prevent multiple submissions

            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: "card",
                card: card,
                billing_details: {
                    name: document.querySelector("input[name='cardholderName']").value,
                    email: "{{ $user->email }}",
                }
            });

            if (error) {
                alert(error.message);
                submitButton.disabled = false; // Re-enable button on error
            } else {
                // Append payment method ID to the form and submit
                var hiddenInput = document.createElement("input");
                hiddenInput.setAttribute("type", "hidden");
                hiddenInput.setAttribute("name", "payment_method_id");
                hiddenInput.setAttribute("value", paymentMethod.id);
                form.appendChild(hiddenInput);

                form.submit();
            }
        });
    });
</script>

@endsection