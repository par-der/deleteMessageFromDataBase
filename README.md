# deleteMessageFromDataBase

Проект рассичтан на то чтобы очищать данные из бд. Это инженерная версия очистки чатов из 1cBitrix с последующим автоудалением. Вы также можете использовать его для своих целей. Для этого понадобится создать 2 базы данных!(clear and database)

![image](https://user-images.githubusercontent.com/62468615/220909209-5c783532-9c52-4cd0-a585-38888f4c39d2.png)
<b>В конечном счете удаление по группам бесед было убранно, поэтом некоторые таблицы не нужны!!!!</b>

<b>В clear создать 4 таблицы:</b>

1) b_group: ![image](https://user-images.githubusercontent.com/62468615/220910413-cfa28262-b943-4a69-b389-a7ab2a2139bd.png)
2) b_im_massgae: ![image](https://user-images.githubusercontent.com/62468615/220910649-3326c74a-0c0a-44c6-bb46-3af6d938ec8c.png)
3) b_user: ![image](https://user-images.githubusercontent.com/62468615/220910956-78ebdd56-ee04-4e72-9358-10aad997843c.png)
4) b_user_group: ![image](https://user-images.githubusercontent.com/62468615/220911146-d51d8af3-784f-484a-a6e5-de9c09476c36.png)


<b>В database создать 1 таблицу:</b>

1) data: ![image](https://user-images.githubusercontent.com/62468615/220911301-61adfc9e-f619-42d4-8f9d-660c5a2a690f.png)




