var form = {
	resultBlock: document.getElementById('result'),
	errorText: {
		1 : "Не заполнено поле 'Имя'<br>",
		2 : "Не заполнено поле 'E-mail'<br>",
		3 : "Не заполнено поле 'Телефон'<br>",
		4 : "Email указан не верно",
	},
	checkEmail: function(email){
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    	return pattern.test(email);
	},

	validator: function(data){
		var self = this;
		self.errorList = [];
		self.errorMsg = [];
		for (var i = 0; i < data.length; i++) {
			el = data[i];
			elName = el.nodeName.toLowerCase();
			value = el.value;
			if (elName == "input") {
				type = el.type.toLowerCase();
				switch (type) {
					case "text" :
						if (el.name == "fio" && value == "") self.errorList.push(1);
						if (el.name == "phone" && value == "") self.errorList.push(3);
						if (el.name == "email" && value == "") self.errorList.push(2);
						else if (el.name == "email" && !self.checkEmail(value)) self.errorList.push(4);
					break;
					default:
			 		break;
		 		}
		 	}
		}

		if (!self.errorList.length) return true;
		self.errorMsg = "При заполнении формы допущены следующие ошибки:\n\n";
		for (i = 0; i < self.errorList.length; i++) {
			self.errorMsg += self.errorText[self.errorList[i]] + "\n";
		}
		return false;
	},

	send: function(data){
		var self = this,
			resultText = '';

		if(!self.validator(data)){ self.resultBlock.innerHTML = self.errorMsg; }
		else{
			$.ajax({
				url: '/defa/mailer.php',
				type: 'POST',
				dataType: 'json',
				data: $(data).serialize(),
				success: function(res){
					console.log(res);
					if(res.status){
						resultText = res.message;
					}
					else{
						for (var i = 0; i < res.errors.length; i++) {
							resultText += res.errors[i]+'<br>';
						};
					}
					self.resultBlock.innerHTML = resultText;
				}
			})			
		}
	}
}