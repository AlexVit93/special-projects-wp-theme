function validateAppointmentForm() {
    const consentCheckbox = document.getElementById("consent_appointment");
    console.log('Consent checkbox checked state:', consentCheckbox.checked);
    if (!consentCheckbox.checked) {
        alert("Вы должны согласиться на обработку персональных данных.");
        return false;
    }
    return true;
}

document.getElementById("appointmentForm").addEventListener("submit", function (event) {
    event.preventDefault();
    console.log('Form submission initiated');
    
    if (validateAppointmentForm()) {
        console.log('Form validation passed');
        var formData = $(this).serialize();
        console.log('Serialized form data:', formData);

        var $submitButton = $(this).find('button[type="submit"]');
        $submitButton.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: ajax_appointment.url,
            data: {
                action: 'submit_appointment_form',
                form_data: formData,
                nonce: ajax_appointment.nonce
            },
            success: function(response) {
                console.log('AJAX response:', response);
                if (response.startsWith('success')) {
                    $('#appointmentForm').hide();
                    $('#confirmationMessage').show();
                } else if (response === 'error: duplicate entry') {
                    alert('Ошибка: запись с такими данными уже существует.');
                } else {
                    alert('Ошибка: ' + response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('AJAX error: ' + textStatus);
            },
            complete: function() {
                $submitButton.prop('disabled', false);
            }
        });
    }
});