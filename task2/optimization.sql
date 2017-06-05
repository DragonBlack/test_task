SELECT * FROM data,link,info WHERE link.info_id = info.id AND link.data_id = data.id;

-- Это классический запрос для отношения "многие ко многим"
-- Для самого запроса я вижу только одно изменение: первой в списке таблиц
-- должна быть таблица link. А вот с самими таблицами нужно поработать.

-- Во-первых изменим тип таблицы на InnoDB, т.к. MyISAM не поддерживает внешние ключи
ALTER TABLE `data` ENGINE InnoDB;
ALTER TABLE `link` ENGINE InnoDB;
ALTER TABLE `info` ENGINE InnoDB;

-- Во-вторых создадим внешние ключи связей
ALTER TABLE link ADD CONSTRAINT link_info_id_fk FOREIGN KEY (info_id) REFERENCES info(id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT link_data_id_fk FOREIGN KEY (data_id) REFERENCES `data`(id) ON DELETE CASCADE ON UPDATE CASCADE;

-- В-третьих в таблице link создадим уникальный индекс
ALTER TABLE link ADD UNIQUE INDEX link_info_data_idx (info_id, data_id);