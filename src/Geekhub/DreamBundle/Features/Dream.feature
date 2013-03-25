# language: ru
Функционал: Страница мрии
  Чтобы участвовать в мрии
  Как посетитель сайта
  Я должен иметь возможность поддержать мрию

  Сценарий: Создание мрии только авторизированым пользователем
    Допустим я на странице "/logout"
    Допустим я на странице "/dream/new"
    То я не должен видеть "Нова мрія"
    Тогда я вхожу как пользователь "demo" с паролем "demo"
    И я на странице "/"
    То я должен видеть "Вітаю, Demo"
    Когда я кликаю по ссылке "+ Додати мрію"
    То я должен видеть "Нова мрія"

  Сценарий: Создание мечты
    Допустим я вхожу как пользователь "demo" с паролем "demo"
    И я на странице "/dream/new"
    И я заполняю поле "geekhub_dreambundle_dreamtype_mainImage" значением "http://farm9.staticflickr.com/8104/8567551995_929bae20fc_b.jpg"
    И я заполняю поле "geekhub_dreambundle_dreamtype_title" значением "Нужен новый ноутбук MacBook Air"
    И я заполняю поле "geekhub_dreambundle_dreamtype_description" значением "MacBook Air поможет мне писать код в 5 раз эфективнее"
    И я заполняю поле "geekhub_dreambundle_dreamtype_phone" значением "8050-555-55-55"
    И я заполняю поле "geekhub_dreambundle_dreamtype_tagArray" значением "тег1, тег2, тег3"
    И галочка "geekhub_dreambundle_dreamtype_phoneAvailable" должна быть отмечена

    Когда я кликаю по ссылке "add_financial_link"
    И я заполняю поле "geekhub_dreambundle_dreamtype_financial_2_name" значением "MacBook Air"
    И я заполняю поле "geekhub_dreambundle_dreamtype_financial_2_quantity" значением "15000"

    Когда я кликаю по ссылке "add_equipment_link"
    И я заполняю поле "geekhub_dreambundle_dreamtype_equipment_2_name" значением "Мишка для ноута"
    И я заполняю поле "geekhub_dreambundle_dreamtype_equipment_2_quantity" значением "4"

    Когда я кликаю по ссылке "add_work_link"
    И я заполняю поле "geekhub_dreambundle_dreamtype_work_2_name" значением "Покрасить ноутбук в голубой цвет"
    И я заполняю поле "geekhub_dreambundle_dreamtype_work_2_quantity" значением "10"

    И я нажимаю "Створити"

    Тогда я должен видеть "Мрія знаходиться на модерації"

  Сценарий: Донейт мечты юзером
    Допустим я вхожу как пользователь "demo" с паролем "demo"
    И я на странице "/"
    То я должен видеть "Нужен новый ноутбук MacBook Air"
    Когда я кликаю по ссылке "Нужен новый ноутбук MacBook Air"
    То я должен видеть "Мрія знаходиться на модерації"
    И я должен видеть "Мрія знаходиться на модерації"
    И я должен видеть "Коментарі та пропозиції"
    И я не должен видеть "Підтримати мрію фінансово"

