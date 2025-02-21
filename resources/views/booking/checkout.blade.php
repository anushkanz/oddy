@extends('layouts.master_open_header')
@section('content')
<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
            Checkout
        </h1>
    </div>
</section>
<!-- <form method="post" action="{{ route('student.booking.checkout.update') }}" data-cc-on-file="false" data-stripe-publishable-key="{{  config('services.stripe.key')  }}" role="form" id="payment-form" class="require-validation">
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
                                <input id="cardNumber" autocomplete="off" placeholder="XXXX XXXX XXXX XXXX" class="input card-number" maxlength="19" name="cardNumber" type="text">
            
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
</form> -->
<form  role="form"  action="{{ route('student.booking.checkout.update') }}"  method="post"  class="require-validation common-form-z" data-cc-on-file="false" data-stripe-publishable-key="{{  config('services.stripe.key')  }}" id="payment-form">

                        @csrf
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class='form-row row sm:col-span-3'>
                            <div class='col-xs-12 form-group required '>
                                <label class='control-label'>Amount</label> 
                                <input class='form-control flex' type='text' name="amount">
                            </div>
                        </div>
                        
                        <div class='form-row row sm:col-span-3'>

                            <div class='col-xs-12 form-group required '>

                                <label class='control-label'>Name on Card</label> 
                                <input class='form-control block' size='4' type='text' name="cardholderName">

                            </div>

                        </div>

    

                        <div class='form-row row sm:col-span-3'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> 
                                <input id="cardNumber" autocomplete='off' placeholder="XXXX XXXX XXXX XXXX" class='form-control card-number flex' maxlength="19"   name="cardNumber" type='text'>
                            </div>
                        </div>

    

                         
                            <div class='sm:col-span-3'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
    
                                    <label class='control-label'>CVC</label> 
                                    <input id="ccvNumber" autocomplete='off' class='form-control card-cvc flex' placeholder='ex. 311'  maxlength="3"  name="cvc" type='text'>
    
                                </div>
                            </div>
                            <div class='sm:col-span-3'>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
    
                                    <label class='control-label'>Expiration Month</label> 
                                    <input class='form-control card-expiry-month flex' placeholder='MM' size='2'  name="expMonth"
    
                                        type='text'>
    
                                </div>
                            </div>
                            <div class='sm:col-span-3'>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
    
                                    <label class='control-label'>Expiration Year</label> 
                                    <input class='form-control card-expiry-year flex' placeholder='YYYY' size='4'  name="expYear" type='text'>
    
                                </div>
                            </div>
                         

                        <div class='form-row row col-span-full'>
                            <div class='col-md-12 error form-group hidden alert alert-error'>
                                <div class='alert-danger alert'>Please correct the errors and try again.</div>
                            </div>
                        </div>

                        <div class="row  col-span-full">
                            <div class="flex gap-x-6">
                                <button class="mb-10 input-btn-red" type="submit">Pay Now </button>
                            </div>
                        </div>

                            
    </div>
                    
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