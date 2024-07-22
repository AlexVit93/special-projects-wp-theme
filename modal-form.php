<div id="appointmentModal" style="display: none;">
    <div class="modal-content">
        <span class="doc-close">&times;</span>
        <form id="appointmentForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Имя</label>
                    <input type="text" name="first_name" id="first_name" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Отчество</label>
                    <input type="text" name="middle_name" id="middle_name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="last_name">Фамилия</label>
                    <input type="text" name="last_name" id="last_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" pattern="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" name="phone" id="phone" pattern="^\+375[1-9]{9}$" maxlength="13" required>
                </div>
                <div class="form-group">
                    <label for="appointment_date">Дата приема</label>
                    <input type="date" name="appointment_date" id="appointment_date" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="appointment_time">Время приема</label>
                    <input type="time" name="appointment_time" id="appointment_time" min="10:30" max="19:30" required>
                </div>
                <div class="form-group">
                    <label for="doctor_name_display">Врач</label>
                    <input type="text" name="doctor_name_display" id="doctor_name_display" readonly>
                    <input type="hidden" name="doctor_name" id="doctor_name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="message">Причина обращения</label>
                    <textarea name="message" id="message"></textarea>
                </div>
            </div>
            <div class="form-row consent-row">
                <input type="checkbox" id="consent_appointment" name="consent_appointment" required>
                <label for="consent_appointment">Я соглас(ен/на) на обработку персональных данных</label>
            </div>
            <button type="submit">Подтвердить запись</button>
        </form>
        <div id="confirmationMessage" style="display: none;">Ваша запись была создана. Ожидайте, с вами свяжется менеджер по номеру телефона или электронной почте на тот адрес, который вы указали при отправке сообщения.</div>
    </div>
</div>
