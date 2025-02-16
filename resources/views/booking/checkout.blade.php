@extends('layouts.master_open_header')
@section('content')
<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
            Checkout
        </h1>
    </div>
</section>
<form method="POST" action="{{ route('student.booking.cart.update') }}" data-cc-on-file="false" data-stripe-publishable-key="{{  config('services.stripe.key')  }}" role="form" class="require-validation">
    @csrf
    <input type='hidden' name='task' value="checkout"> 
    <input type='hidden' name='booking_id' value="{{$booking->_id}}"> 
    <input type='hidden' name='user_id' value="{{$user->_id}}"> 
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
                                     @php 
                                        $fee_percentage = 0.963; // Change this value to set the desired fee percentage
                                        $payment_processing_fee =  (($booking->classes->price + 0.3)/0.963) - $booking->classes->price;
                                        $charge = round($booking->classes->price + $payment_processing_fee, 2);         
                                    @endphp
                                <input type="text" autocomplete="on" name="amount" value="{{ $charge }}" class="input" required disabled>
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
                                <input id="cardNumber" type="text" autocomplete="off" name="cardNumber" placeholder="XXXX XXXX XXXX XXXX" class="input" maxlength="19" required>
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
                                <input id="cvcNumber" type="text" autocomplete="off" name="cvc" placeholder="ex. 311" class="input" maxlength="3" required>
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
                                <input type="text" autocomplete="off" name="expMonth" placeholder="MM" class="input" size='2' required>
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
                                <input type="text" autocomplete="off" name="expYear" placeholder="YYYY" class="input" size='4' required>
                            </div>
                            <p class="help">Required.</p>
                        </div>
                    </div>
                </div>
                <div class="field error">
                    <div class="label">Please correct the errors and try again.</div>
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
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

$(function() {
   /*------------------------------------------
    --------------------------------------------
    Form Format
    --------------------------------------------
    --------------------------------------------*/
    // Handle Card Number update
    const inputCardNumber = document.getElementById("cardNumber");
    inputCardNumber.addEventListener("input", (event) => {
      //   Remove all non-numeric characters from the input
      const input = event.target.value.replace(/\D/g, "");
    
      // Add a space after every 4 digits
      let formattedInput = "";
      for (let i = 0; i < input.length; i++) {
        if (i % 4 === 0 && i > 0) {
          formattedInput += " ";
        }
        formattedInput += input[i];
      }
    
      inputCardNumber.value = formattedInput;
      imageCardNumber.innerHTML = formattedInput;
    });
    
    // Handle CCV update
    const inputCCVNumber = document.getElementById("ccvNumber");
    
    inputCCVNumber.addEventListener("input", (event) => {
      // Remove all non-numeric characters from the input
      const input = event.target.value.replace(/\D/g, "");
      inputCCVNumber.value = input;
      imageCCVNumber.innerHTML = input;
    });

    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/

    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]','input[type=text]', 'input[type=file]','textarea'].join(', '),

        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hidden');

        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hidden');
                e.preventDefault();
            }
        });
     
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });

    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hidden')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
    
 
});



</script>
@endsection