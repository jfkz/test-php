# Скрипт

Запускать: `php parse.php`.

Генерирует суммы от -100 до 11000 на зафиксированный кошелек. Если распарсил - пишет распарсенные данные, если нет - просто выводит пришедшую ошибку.


## Тестовое задание
Задание рассчитано на 3 часа. Вы можете потратить и больше времени, это не так важно, как результат.

Представьте, что вы используете популярный сервис "Яндекс.Деньги" и периодически переводите деньги со своего кошелька на кошельки других пользователей. Вы хотите автоматизировать данный процесс, но в самом сервисе отсутствует API для подобных действий. Само собой, вас это нисколько не смущает, однако, в ходе разработки вы столкнулись с тем, что каждая операция требует SMS-подтверждения.

Итак, вы уже настроили свой телефон таким образом, что он передает текст SMS-сообщений от "Яндекс.Денег" вашей PHP-процедуре, но теперь вам необходимо разобрать данный текст.

Напишите на PHP функцию, которая принимает строку (текст сообщения) и возвращает извлеченные из неё код подтверждения, сумму и кошелек. Для генерации сообщений воспользуйтесь эмулятором. Мы написали эмулятор (а не просто текст) не просто так: выдаваемый им текст может изменяться (точно так же, как это происходит с реальными "Яндекс.Деньгами"), поэтому вам нужно как следует исследовать его. В перспективе, пожалуйста, учтите так же, что порядок полей, пунктуация и слова со временем могут быть изменены, что является обычным делом для платежных систем. Поэтому вам нужна универсальная функция, написанная с помощью регулярных выражений, которая будет работать в любом случае.

Решение должно полностью соответствовать заданию, ни больше ни меньше. Оно должны быть качественным, красивым и простым. Требуемая функциональность должна быть реализована практически идеально. Учтите, мы будем придираться к мелочам. При этом, пожалуйста, не усложняйте. Не нужно создавать десятки интерфейсов и вспомогательных классов, не нужно писать тесты, не нужно создавать готовые приложения.
