// Calcul du prix total
$(document).ready(function() {
    showPrixTotal();
    $('#dateDebut').change(function() {
      showPrixTotal();
    });
    $('#dateFin').change(function() {
      showPrixTotal();
    });
});

// Create a Stripe client.
var stripe = Stripe('pk_test_yQUEcQZrvOTtFqpP7MfNbKG6');
var elements = stripe.elements();
var displayError = document.getElementById('card-errors');
displayError.hidden = true;

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  if (event.error) {
    displayError.textContent = event.error.message;
    displayError.hidden = false;
  } else {
    displayError.textContent = '';    
    displayError.hidden = true;
  }
});

// Handle form submission.
var form = document.getElementById('paiement-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('paiement-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}

/**
 * Permet de calculer le prix total
 */
function calculTotal() {
  var prix = document.getElementById('prixUni').value;
  if(prix > 0) {
    var valDebut = document.getElementById('dateDebut').value;
    var valFin = document.getElementById('dateFin').value;
    var dateDebut = new Date(dateFrToIso(valDebut));
    var dateFin = new Date(dateFrToIso(valFin));
    var nbDays = Math.round((dateFin - dateDebut)/(1000*60*60*24));
    return nbDays * prix;
  }
  return 0;
}

function dateFrToIso(date) {
  var dateArr = date.split('/');
  dateArr.reverse();
  return dateArr.join('-');
}

function showPrixTotal() {  
  $('#prixTotal').val(calculTotal());
  $('#spanTotal').html(calculTotal() + ' €');
}