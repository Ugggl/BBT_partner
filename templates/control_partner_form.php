<!-- CONTROL PARTNER FORM -->
<div class="form_control_partner">
	<div class="close_form"><img src="/img/close_form.svg" alt="close_form" height="18"></div>

	<p class="modal_title">Управление партнером</p>
	<form id="control_partner_form" method="POST">
		<input type="hidden" id="new_partner_id">
		<input type="text" id="new_partner_name" placeholder="Фамилия, Имя и Отчество партнера">
		<input type="text" id="new_partner_region" placeholder="Населенный пункт">
		<label>Выручка за эл. книги<input type="text" id="new_get_digital"><span class="get_percent">%</span></label>
		<label>Выручка за аудиокниги<input type="text" id="new_get_audio"><span class="get_percent">%</span></label>
		<input type="text" id="new_partner_email" placeholder="Эл. почта">
		<div class="control_partner_form_pass">
			<input type="password" id="new_partner_password" placeholder="Пароль">
			<img src="/img/eye.svg" alt="show password" class="pass_eye">
		</div>
	</form>
	<button id="control_partner_submit" type="button">Сохранить</button>
	<p class="delete_partner"><span id="delete_partner">Удалить партнера</span></p>
</div>
<!-- END CONTROL PARTNER FORM -->