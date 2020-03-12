<?php

function get_data($reciever, $amount) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL,"https://funpay.ru/en/yandex/emulator");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,
    http_build_query(array(
      'receiver' => $reciever,
      'sum' => $amount,
    ))
  );
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "x-requested-with: XMLHttpRequest",
  ));

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $server_output = curl_exec($ch);
  curl_close ($ch);

  return $server_output;
}

class Parser {
  // Заготовки регекспов
  private static $regexes = array(
    'pass' => '([0-9]{4,5})', // Я видел пароли длиной только 4 и 5 символов, поэтому тут так.
    'sum'  => '([0-9]+[\.\,][0-9]{1,2})', // Сумма всегда была с копейками, но, возможно, это самое легкое место для придирок
    'wallet' => '([0-9]{13,16})', // Я потыкал варианты кошельков, они от 13 до 16 символов.
  );
  private static $regex_delimeter = '.*\s'; // Перед цифрой я всегда видел что-то похожее на пробел. Ну и вряд ли яндекс будет лепить: "Код123456"

  private $regex_keys = array();
  private $mutations = array();

  function __construct() {
    $this->regex_keys = array_keys(static::$regexes);
    $this->generate_mutations(array()); // Мутанируем
  }

  // Здесь всякая магия, но вроде вполне понятная
  private function generate_mutations($mutation) {
    if (count($mutation) == count($this->regex_keys)) {
      $this->mutations[] = $mutation;
      return;
    }
    foreach($this->regex_keys as $key) {
      if (!in_array($key, $mutation)) {
        $this->generate_mutations(array_merge($mutation, array($key)));
      }
    }
  }

  private function parse_mutation($data, $mutation) {
    $regex_data = array();
    foreach($mutation as $mut) {
      $regex_data[] = static::$regexes[$mut];
    }
    $regex = implode(static::$regex_delimeter, $regex_data);
    $regex = sprintf("/%s/ms", $regex);
    if (preg_match($regex, $data, $matches) === 1) {
      $result = array();
      for ($i = 0; $i < count($mutation); $i++) {
        $result[$mutation[$i]] = $matches[$i+1];
      }
      return $result;
    }
    return false;
  }

  // Это парсер
  public function parse($data) {
    foreach($this->mutations as $mutation) {
      if (($parsed = $this->parse_mutation($data, $mutation)) !== false) {
        return $parsed;
      }
    }
    // Если мы ничего не нашли, похоже, строка отображает ошибку.
    // Мы можем её тоже попарсить, но такого в задании не было.
    return $data;
  }
}

$parser = new Parser();
$reciever = '41001234567890'; // Захардкодим, этого нам в задаче не запретили

// Будем тыкать в генерилку и пытаться понять её ответы. Пока ^C не разлучит нас.
while(true) {
  $amount = mt_rand() / mt_getrandmax() * 11000 - 100;
  printf("\n\n>>> Generated amount: %f\n\n", $amount);

  $data = get_data($reciever, $amount);
  printf(">>> Recieved data:\n%s \n\n", $data);

  $parsed = $parser->parse($data);
  if (!is_array($parsed)) {
    printf(">>> Parsed exception:\n%s \n\n", $parsed);
  } else {
    printf(">>> Parsed data:\n%s \n\n", var_export($parsed, true));
  }

  sleep(10);
}

?>
