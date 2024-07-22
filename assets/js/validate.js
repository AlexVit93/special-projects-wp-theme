function validateContactForm() {
    const consentCheckbox = document.getElementById("consent_contact");
    if (!consentCheckbox) {
        console.error("Consent checkbox for contact form not found.");
        return false;
    }
    if (!consentCheckbox.checked) {
        alert("Вы должны согласиться на обработку персональных данных.");
        return false;
    }
    return true;
}

async function onReCaptchaSuccess(token) {
    const formData = new FormData(document.getElementById("contactForm"));
    formData.append('g-recaptcha-response', token);
    formData.append('security', ajax_feedback.nonce);

    try {
        const response = await fetch(ajax_feedback.url, {
            method: 'POST',
            body: formData,
        });
        const data = await response.json();
        if (data.success) {
            alert(data.data.message);
            document.getElementById("contactForm").reset();
        } else {
            alert(data.data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз.');
    }
}

function showMathCaptcha() {
    let modal = document.getElementById("mathCaptchaModal");
    let span = document.getElementsByClassName("rec-close")[0];
    let submitMathAnswer = document.getElementById("submitMathAnswer");

    let num1 = Math.floor(Math.random() * 10);
    let num2 = Math.floor(Math.random() * 10);
    document.getElementById("mathQuestion").textContent = `${num1} + ${num2}`;
    let correctAnswer = num1 + num2;

    modal.style.display = "block";

    submitMathAnswer.onclick = function() {
        let userAnswer = parseInt(document.getElementById("mathAnswer").value);
        if (userAnswer === correctAnswer) {
            modal.style.display = "none";
            grecaptcha.ready(function() {
                grecaptcha.execute('6LetyAgqAAAAAKao1wU10I_yrjfbscVTMqw8tHkN', {action: 'submit'}).then(function(token) {
                    onReCaptchaSuccess(token);
                });
            });
        } else {
            alert("Неправильный ответ. Попробуйте еще раз.");
        }
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
}

document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault();
    if (validateContactForm()) {
        showMathCaptcha();
    }
});

