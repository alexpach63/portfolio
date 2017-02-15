<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/defa/style.css">
	<title>Document</title>
</head>
<body>
<div class="form">
	<form id="form" onsubmit="form.send(this); return false;">
		<input type="text" class="form__elem" name="fio" placeholder="ФИО">
		<input type="text" class="form__elem form__elem--invalid" name="phone" placeholder="Телефон">
		<input type="text" class="form__elem" name="email" placeholder="Email">
		<textarea name="comment" class="form__elem" placeholder="Комментарий"></textarea>
		<button type="submit" class="form__submit">Отправить</button>
	</form>

	<div id="result" class="form__result">Ваша заявка принята</div>
</div>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
	<script src="/defa/js.js"></script>
</body>
</html>