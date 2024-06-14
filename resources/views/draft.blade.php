<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset ('assets/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset ('assets/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset ('assets/css/bootstrap.min.css') }}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset ('assets/css/style.css') }}">

    <title>BNBL</title>
  </head>
<body>

<!--CSS Spinner-->
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
    <p class="mb-4">Please be informed that your new account number will be shown once  entered information is verified.</p>
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
          <div class="col-md-6">
            <div class="form-group first">
              <label for="lname">CID</label>
              <input type="text" name="cid" class="form-control" placeholder="CID" id="cid">
              <span id="cidError" class="text-danger"></span>
            </div>    
          </div>
          <div class="col-md-6">
            <div class="form-group first">
              <label for="lname">Phone Number</label>
              <input type="phone" class="form-control" name="phone_number" placeholder="Phone Number" maxlength="8"
              id="phone_number" pattern="(17|77|16)\d{6}" title="Please enter a valid 8-digit number starting with 17 or 77.">
              <span id="phoneError" class="text-danger"></span>
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
          <div class="col-md-6">
            <div class="form-group first">
              <label for="lname">Phone Number</label>
              <input type="phone" class="form-control" name="phone" placeholder="Phone Number" maxlength="8"
              id="phone" pattern="(17|77)\d{6}" title="Please enter a valid 8-digit number starting with 17 or 77.">
              <span id="phoneErrorCor" class="text-danger"></span>
            </div>    
          </div>
        </div>
        <span id="cidError" class="text-danger" style="text-align: center ;"></span>
        <!-- <div class="d-flex mb-5 mt-4 align-items-center"> -->
        <input type="submit" value="Submit" class="btn px-5 btn-primary" style="background-color: #252D60; color: #fff;">
        <!-- </div>  -->
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
      $('#cid').val(''); 
      $('#phone_number').val(''); 
      $('#old_account_number').val(''); 
      $('#new_account').text(''); 
    }

      $('#customer_type').on('change', function() {
        var selectedOption = $(this).val();
           // Hide all rows initially
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
    // Add an event listener to the form submission
    $('form').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var formData = $(this).serialize(); // Serialize the form data
        // Check the serialized form data

        // Send an AJAX request to the server
        $.ajax({
            type: 'GET',
            url: '/check-account',
            data: formData,
            dataType: 'json',
            success: function(response) {
                const data = response.data;

                if (data && data.new_account) {
                    // Show the data container if data is found
                    $('#new_account').text(data.new_account);
                    $('#name').text(data.customer_name1);
                    $('#dataContainer').show();
                } else {
                    // Hide the data container if data is not found
                    $('#dataContainer').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Log any errors
                if (xhr.responseJSON && xhr.responseJSON.error) {
            // Display custom error message from server
            // window.alert(xhr.responseJSON.error);
            $('.text-danger').empty(); // Clear existing error messages

// Update error message for specific fields
              if (xhr.responseJSON.error_field === 'phone_number') {
                  $('#phoneError').text(xhr.responseJSON.error);
                  removeErrorAfterDelay('#phoneError'); // Call function to remove error after delay
              } else if (xhr.responseJSON.error_field === 'cid') {
                  $('#cidError').text(xhr.responseJSON.error);
                  removeErrorAfterDelay('#cidError'); // Call function to remove error after delay
              } else if (xhr.responseJSON.error_field === 'oldaccountError') {
                  $('#oldaccountError').text(xhr.responseJSON.error);
                  removeErrorAfterDelay('#oldaccountError'); // Call function to remove error after delay
              } else if (xhr.responseJSON.error_field === 'oldaccountErrorCor') {
                  $('#oldaccountErrorCor').text(xhr.responseJSON.error);
                  removeErrorAfterDelay('#oldaccountErrorCor'); // Call function to remove error after delay
              } else if (xhr.responseJSON.error_field === 'phoneErrorCor') {
                  $('#phoneErrorCor').text(xhr.responseJSON.error);
                  removeErrorAfterDelay('#phoneErrorCor'); // Call function to remove error after delay
              }

              // Function to remove error message after a delay
              function removeErrorAfterDelay(elementSelector) {
                  setTimeout(function() {
                      $(elementSelector).text(''); // Remove the error message content
                  }, 5000); // Adjust the delay time (in milliseconds) as needed
              }

        } else {
          window.alert('An error occurred. Please try again later.', 'danger');
        }
                
            }
        });
    });

    // Function to reset the form and hide the data container
    function resetForm() {
        $('form')[0].reset();
        $('#dataContainer').hide();
    }
});

</script>


    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide the success message after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>

  </body>
</html>