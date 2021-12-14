CDlukashWorkers::getAllStaffWithID() − вернуть список работников с идентификаторами;
CDlukashWorkers::getAllOfficesWithID()− вернуть список офисов с идентификаторами;
CDlukashWorkers::getAllStaffWithOffice()− вернуть список работников с офисами в формате ID / ФИО / Должность /
Телефон / Офис / Адрес;
CDlukashWorkers::updateStaffByID(int $ID, array $arFields)− обновить данные работника по идентификатору;
CDlukashWorkers::addStaff(array $arFields)− добавить работника;
CDlukashWorkers::deleteStaffByID(int $ID)− удалить работника;
CDlukashWorkers::findStaffByFIO(string $FIO)− найти и вернуть работников при совпадении данных ФИО
(регистронезависимый поиск)

не все маршруты дописал для rest api