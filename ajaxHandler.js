// COPYRIGHT (C) HARRY CLARK 2024
// PHP PASSWORD GENERATOR AJAX HANDLER 

// THIS FILE PERTAINS TOWARDS THE MAIN FUNCTIONALITY OF
// ALLOWING THE PHP FILE TO COMMUNICATE WITH THE POST AND GET METHODS

$(document).ready(function() 
{
    $('#generatorControls').hide(); 

    $('#useGenerator').on('change', function() 
    {
        if ($(this).is(':checked')) 
        {
            $('#generatorControls').slideDown(); 
        } 
        else 
        {
            $('#generatorControls').slideUp();
        }
    });

    $('#generateBtn').on('click', function() 
    {
        $('#errorMessage').hide();

        if (!$('#hasUpper').is(':checked') && 
            !$('#hasLower').is(':checked') && 
            !$('#hasNums').is(':checked') && 
            !$('#hasSyms').is(':checked')) 
            {
            $('#errorMessage').text('Please select at least one character type').show();
            return;
        }

        const requestData = 
        {
            length: parseInt($('#passwordLength').val()),
            requirements: 
            {
                HAS_UPPER: $('#hasUpper').is(':checked') ? 1 : 0,
                HAS_LOWER: $('#hasLower').is(':checked') ? 1 : 0,
                HAS_NUMBER: $('#hasNums').is(':checked') ? 1 : 0,
                HAS_SYMBOL: $('#hasSyms').is(':checked') ? 1 : 0,
                MIN_UPPER: 1,
                MIN_LOWER: 1,
                MIN_NUMBER: 1,
                MIN_SYMBOL: 1
            }
        };

        console.log("Sending AJAX request with data:", requestData);

        $.ajax(
        {
            url: 'password.php',
            method: 'POST',
            data: JSON.stringify(requestData),
            contentType: 'application/json',
            success: function(response) 
            {
                console.log("Response from server:", response);

                if (response.password) 
                {
                    $('#password').val(response.password);
                } 
                else 
                {
                    $('#errorMessage').text(response.error || 'Failed to generate password').show();
                }
            },
            error: function(xhr, status, error) 
            {
                $('#errorMessage').text('Error: ' + error).show();
                console.error("AJAX Error:", status, error);
            }
        });
    });

    // Update the displayed length value when the range input changes
    $('#passwordLength').on('input', function() {
        $('#lengthValue').text($(this).val());
    });
});
