ALTER TABLE `b_dlukash_staff` ADD FOREIGN KEY (`OFFICE_ID`) REFERENCES `b_dlukash_offices`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `b_dlukash_staff` ADD FOREIGN KEY 
(`POST_ID`) REFERENCES `b_dlukash_posts`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `b_dlukash_posts` (`ID`, `POST`) VALUES
(1, 'Администратор'),
(3, 'Управляющий'),
(4, 'Специалист'),
(5, 'Оператор'),
(6, 'Кассир'),
(7, 'Бухгалтер');

INSERT INTO `b_dlukash_offices` (`ID`, `OFFICE`, `ADRESS`) VALUES
(1, 'Северный', 'Дзержинского, 20'),
(2, 'Центральный', 'Ленина, 51'),
(3, 'Западный', 'Солнечная, 37А'),
(4, 'Октябрьский', 'Октябрьский, 98');

INSERT INTO `b_dlukash_staff` (`ID`, `FIO`, `PHONE`, `OFFICE_ID`, `POST_ID`) VALUES
(1, 'Иванов Дмитрий Сергеевич', 2137, 1, 5),
(2, 'Кочкина Дарья Алексеевна', 2101, 2, 1),
(3, 'Сергеев Юрий Витальевич', 2112, 2, 3),
(4, 'Баранов Сергей Вадимович', 2117, 1, 4),
(5, 'Михайлов Максим Юрьевич', 2122, 3, 5),
(6, 'Фомина Анна Валентиновна', 2120, 2, 6),
(7, 'Носков Андрей Витальевич', 2131, 4, 4),
(8, 'Соколова Анна Валерьевна', 2130, 2, 7),
(9, 'Шахматов Алексей Алексеевич', 2125, 3, 4),
(10, 'Ершов Дмитрий Иванович', 2128, 4, 4);

INSERT INTO `b_dlukash_users` (`ID`, `LOGIN`, `PASSWD`, `LAST_AUTH`) VALUES
(1, 'admin', 'test123', '2021-12-14 04:30:08'),
(2, 'manager', 'qweasd', '2021-12-14 04:30:08');
