@extends('layouts.master_open_header')
@section('content')


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