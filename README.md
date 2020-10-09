#  Call The List 
**Description:**  
Проект, который добавляет сделки в список обзвона при перемещении их на определенный этап,
 с помощью вебхука и скрипта `newleads.php`. Затем с помощью демона `pydemon`, который
 запускает скрипт `call.php` в определенное время, обзванивает клиентов данной сделки.
 
## Настройка
Необходимо заполнить значения переменных в файле `functions/environment.php`:  
1. $pipeline_id - id воронки, на которой находится функционал.   
Получить id всех воронок можно скриптом `functions/getPipelines.php`. Например:
2. $status_id_main - id этапа, на котором находятся номера для обзвона Сделка, которая будет находится на этом этапе будет прозваниваться по времени.
3. $status_id_next - id этапа, на который попадают сделки после обзвона
```
# Пример использования скриптов для получения значений
# получить id Воронок
curl http://ats.karnavalnn.ru/amocrm/callthelist/functions/getPipelines.php

# получить id этапов воронки с id 3571748
curl http://ats.karnavalnn.ru/amocrm/callthelist/functions/getStatuses.php?id=3571748
```
