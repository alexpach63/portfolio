<?

class Mailer {
	public $result = '';
	protected $to = 'krash0537@mail.ru';
	protected $title = 'Тестовое письмо';
	protected $from = 'dev@alexpach.ru';

	public function checkEmail($email) {
		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){return true;}
		return false;
	}

	public function logging() {
		$file = dirname(__FILE__).'/mails.txt';
		$current = file_get_contents($file);
		$current .= "Отправлено письмо ".date("m.d.y H:i:s")."\n";
		file_put_contents($file, $current, FILE_APPEND);
	}

	public function validate($data){
		if(isset($data['fio']) && empty($data['fio'])){ $this->result['errors'][] = "Не заполнено поле 'Имя'";}
		if(isset($data['phone']) && empty($data['phone'])){ $this->result['errors'][] = "Не заполнено поле 'Телефон'";}
		if(isset($data['email']) && empty($data['email'])){ $this->result['errors'][] = "Не заполнено поле 'E-mail'";}
		else if(isset($data['email']) && !$this->checkEmail($data['email'])){$this->result['errors'][] = "Email указан не верно";}

		if(!empty($this->result['errors'])) return false;
		else return true;
	}

	public function send(){

		$this->result['status'] = false;

		if(!$this->validate($_POST)){
			$this->result['message'] = 'Присутствуют ошибки :';
		}
		else{
			$message = "Имя: ".$_POST['fio'];
			$message .= "\nТелефон: ".$_POST['phone'];
			$message .= "\nEmail: ".$_POST['email'];
			if(isset($_POST['comment']) && !empty($_POST['comment'])) $message .= "\nКомментарий: ".$_POST['comment'];

			if(mail($this->to, $this->title, $message, 'From:'.$this->from)){
				$this->logging();
				$this->result['status'] = true;
				$this->result['message'] = 'Письмо успешно отправлено';
			}
		}
		echo json_encode($this->result);
	}
}

$mailer = new Mailer();

$mailer->send($_POST);