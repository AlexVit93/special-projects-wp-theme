function updateDateRestrictions() {
    const doctorName = $('#doctor_name').val();
    const appointmentDateInput = $('#appointment_date');

    const evenDaysDoctors = ["Иванова Ольга Павловна", "Левая Алина Викторовна", "Есенин Павел Валерьевич"]; 
    const oddDaysDoctors = ["Новиков Сергей Игоревич", "Веселова София Станиславовна"]; 

    appointmentDateInput.off('input');

    if (evenDaysDoctors.includes(doctorName)) {
        appointmentDateInput.on('input', function () {
            const date = new Date(this.value);
            if (date.getDate() % 2 !== 0) {
                this.value = '';
                alert('Для этого врача доступны только четные дни.');
            }
        });
    } else if (oddDaysDoctors.includes(doctorName)) {
        appointmentDateInput.on('input', function () {
            const date = new Date(this.value);
            if (date.getDate() % 2 === 0) {
                this.value = '';
                alert('Для этого врача доступны только нечетные дни.');
            }
        });
    }
}

jQuery(document).ready(function($) {
    console.log('Document ready');

    $(document).on('click', '.doctors__info-appointment.button', function() {
        console.log('Button clicked');
        var doctorName = $(this).data('doctor-name');
        console.log('Doctor name:', doctorName);
        $('#doctor_name').val(doctorName);
        $('#doctor_name_display').val(doctorName);

        updateDateRestrictions();

        var $modal = $('#appointmentModal');
        console.log('Modal element:', $modal);
        $modal.show();
        console.log('Modal display:', $modal.css('display'));
    });

    $('.doc-close').click(function() {
        console.log('Close button clicked');
        $('#appointmentModal').hide();
    });

    $(window).click(function(event) {
        if (event.target.id === 'appointmentModal') {
            console.log('Window clicked outside modal');
            $('#appointmentModal').hide();
        }
    });

    $('#appointmentForm').submit(function(e) {
        e.preventDefault(); 
        console.log('Form submitted');
        var formData = $(this).serialize(); 
        console.log('Form data:', formData);

        if (validateForm()) {
            $.ajax({
                type: 'POST',
                url: ajaxurl, 
                data: {
                    action: 'submit_appointment_form',
                    form_data: formData
                },
                success: function(response) {
                    console.log('AJAX response:', response);
                    if (response.startsWith('success')) {
                        $('#appointmentForm').hide();
                        $('#confirmationMessage').show();
                    } else if (response.startsWith('duplicate')) {
                        alert('Ошибка: запись с такими данными уже существует.');
                    } else {
                        alert('Ошибка: ' + response);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('AJAX error: ' + textStatus);
                }
            });
        }
    });
});
