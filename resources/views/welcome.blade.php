<!doctype html>
<html lang="en">
  <head>
 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset ('assets/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset ('assets/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset ('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset ('assets/css/style.css') }}">

    <title>BNBL</title>
  </head>
<body>

<div class="spinner-wrapper" style="display: none;" id="preloader">
<div class="spinner-border" role="status"></div>
</div>

<div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="{{ asset('assets/images/Logo_Primary.png') }}" alt="Company Logo" width="160">
        <h5>Get Your New Account Number</h5>
      </div>
    </div>
  </div>

<div class="container" style="margin-top: -50px;">
  <div class="row align-items-center justify-content-center">
    <div class="col-md-7 py-5">
    <p class="mb-4">Please be informed that your new account number will be shown once the entered old account number is valid.</p>
      <form action="{{ route('check.account') }}" method="get">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="form-group first" style="margin-top: -20px;">
              <label for="lname">Choose Customer Type</label>
              <select class="form-control" name="customer_type" id="customer_type" required>
                <option value="">Select</option>
                <option value="Individual">Individual</option>
                <option value="Corporate">Corporate</option>
              </select>
            </div>    
          </div>
        </div>
        <div class="row" id="individual_row" style="display: none;">
          <div class="col-md-6">
            <div class="form-group first">
              <label for="account_number">Old Account Number</label>
              <input type="text" name="account_number" class="form-control" 
              placeholder="51XXXXXXXXXXXX" id="account_number" maxlength="13">
              <span id="oldaccountError" class="text-danger"></span>
            </div>    
           
          </div>
        </div>
        <div class="row" id="corporate_row" style="display: none;">
          <div class="col-md-6">
            <div class="form-group first">
              <label for="fname">Old Account Number</label>
              <input type="text" name="old_account_number" class="form-control" placeholder="51XXXXXXXXXXXX" 
              id="old_account_number" maxlength="13" >
              <span id="oldaccountErrorCor" class="text-danger"></span>
            </div>    
          </div>
        </div>
        <span id="cidError" class="text-danger" style="text-align: center ;"></span>
        <input type="submit" value="Submit" class="btn px-5 btn-primary" style="background-color: #252D60; color: #fff;">
        <div id="dataContainer" style="display:none; background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-top: 10px; justify-content: flex-start;">
    Dear Customer, <br>
    Your account details are as follows:<br> 
    1. Account Number: <strong id="new_account"></strong> <br>
    2. Account Name: <strong id="name"></strong> <br>
    Thank you for the inquiry.
</div>


      </form>

    </div>
  </div>
</div>


    <script src="{{ asset ('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset ('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset ('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset ('assets/js/main.js') }}"></script>

    <script>
			function showData() {
				$('#dataContainer').fadeIn();
				}
		</script>
  
  <script>
    $(document).ready(function() {
      function resetForm() {
      $('#dataContainer').hide(); 
      $('#account_number').val(''); 
      $('#old_account_number').val(''); 
      $('#new_account').text(''); 
    }

      $('#customer_type').on('change', function() {
        var selectedOption = $(this).val();
      $('#individual_row').hide();
      $('#corporate_row').hide();

      if (selectedOption === 'Individual') {
        $('#individual_row').show();
        resetForm();
      }else{
        $('#corporate_row').show();
        resetForm();
      } 
      })
    })
  </script>

<script>
  $(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault(); 

        var formData = $(this).serialize(); 

        $.ajax({
            type: 'GET',
            url: '/check-account',
            data: formData,
            dataType: 'json',
            success: function(response) {
                const data = response.data;

                if (data && data.new_account) {
                    $('#new_account').text(data.new_account);
                    $('#name').text(data.customer_name1);
                    $('#dataContainer').show();
                } else {
                    $('#dataContainer').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
                if (xhr.responseJSON && xhr.responseJSON.error) {
            $('.text-danger').empty();

              if (xhr.responseJSON.error_field === 'oldaccountError') {
                $('#oldaccountError').text(xhr.responseJSON.error);
                removeErrorAfterDelay('#oldaccountError'); 
              } else{
                $('#oldaccountErrorCor').text(xhr.responseJSON.error);
                removeErrorAfterDelay('#oldaccountErrorCor'); 
              }

              function removeErrorAfterDelay(elementSelector) {
                  setTimeout(function() {
                      $(elementSelector).text(''); 
                  }, 5000); 
              }

        } else {
          window.alert('An error occurred. Please try again later.', 'danger');
        }
                
            }
        });
    });

    function resetForm() {
        $('form')[0].reset();
        $('#dataContainer').hide();
    }
});

</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>

  </body>
</html>