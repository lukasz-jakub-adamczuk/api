
-- users
INSERT INTO `renaissance-dev`.`user` (`id_user`, `id_user_group`, `email`, `hash`, `secret`, `name`, `slug`, `avatar`, `real_name`, `register_date`, `last_visit_date`, `active`, `sz_perm`) VALUES
(NULL, 0, 'loyal.royal@gilbert.biz','' ,'' ,'Loyal' ,'' ,'' ,'Britney Quitzon' , NOW(), NULL, 0, ''),
(NULL, 0, 'Kennedy@fabian.name','' ,'' ,'Chelsea' ,'' ,'' ,'Curt Treutel' , NOW(), NULL, 0, ''),
(NULL, 0, 'Justen@randi.io','' ,'' ,'Moises' ,'' ,'' ,'Roman Erdman' , NOW(), NULL, 0, ''),
(NULL, 0, 'raul.co.uk','' ,'' ,'Cornelius' ,'' ,'' ,'Deshawn Wilkinson' , NOW(), NULL, 0, ''),
(NULL, 0, 'Bernita@luisa.io','' ,'' ,'Alexzander' ,'' ,'' ,'Fausto Ritchie' , NOW(), NULL, 0, ''),
(NULL, 0, 'Prince@brown.biz','' ,'' ,'Reginald' ,'' ,'' ,'Raymundo Reichel' , NOW(), NULL, 0, ''),
(NULL, 0, 'German@delbert.net','' ,'' ,'Antonio' ,'' ,'' ,'Dr. Gayle Fisher' , NOW(), NULL, 0, ''),
(NULL, 0, 'Boyer@earline.biz','' ,'' ,'Misael' ,'' ,'' ,'Lyla Thompson' , NOW(), NULL, 0, ''),
(NULL, 0, 'Catalina@brice.tv','' ,'' ,'Rosanna' ,'' ,'' ,'Neva Maggio' , NOW(), NULL, 0, ''),
(NULL, 0, 'Malachi@rosina.tv','' ,'' ,'Shea' ,'' ,'' ,'Gracie Little' , NOW(), NULL, 0, '')

-- article categories
INSERT INTO `renaissance-dev`.`article_category` (`id_article_category`, `name`, `slug`, `abbr`, `creation_date`, `modification_date`, `idx`, `se`, `visible`, `deleted`) VALUES 
(NULL, 'Chrono Cross', 'chrono-cross', 'cc', NULL, NULL, '0', '0', '1', '0'),
(NULL, 'Final Fantasy VIII', 'final-fantasy-viii', 'ff8', NULL, NULL, '0', '0', '1', '0'),
(NULL, 'Legend of Mana', 'legend-of-mana', 'lom', NULL, NULL, '0', '0', '1', '0'),
(NULL, 'Final Fantasy IV', 'final-fantasy-iv', 'ff7', NULL, NULL, '0', '0', '1', '0');

-- articles
INSERT INTO `renaissance-dev`.`article` (`id_article`, `id_article_category`, `id_article_template`, `id_author`, `title`, `slug`, `old_url`, `markup`, `markdown`, `creation_date`, `modification_date`, `rated`, `sum`, `views`, `idx`, `verified`, `visible`, `deleted`) VALUES (NULL, '1', NULL, '1', 'Recenzja', 'recenzja', NULL, 'Przyszłość zawsze pozostaje nieznana, a próby jej przewidzenia nie zawsze są trafne. Świat ludzi będzie zupełnie inny, ale jak bardzo różny od tego, który znamy dzisiaj? Deus Ex: Human Revolution to wizja świata przyszłości, interesującego i niebezpiecznego jednocześnie. Historia gry opisuje wydarzenia z 2027 roku, zatem jeszcze przed wydarzeniami z pierwszej części gry.

Fabuła

Deus Ex: Bunt Ludzkości pokazuje świat pełen nauki i techniki. Adam Jensen jest szefem ochrony w firmie Sarif Industries, która zajmuje się ulepszeniami biomechanicznymi dla ludzi. Rynek wszczepów jest opanowany przez kilka korporacji, ale wyższe dobro nie jest nadrzędnym celem dla wszystkich z nich.', 'Przyszłość zawsze pozostaje nieznana, a próby jej przewidzenia nie zawsze są trafne. Świat ludzi będzie zupełnie inny, ale jak bardzo różny od tego, który znamy dzisiaj? Deus Ex: Human Revolution to wizja świata przyszłości, interesującego i niebezpiecznego jednocześnie. Historia gry opisuje wydarzenia z 2027 roku, zatem jeszcze przed wydarzeniami z pierwszej części gry.

Fabuła

Deus Ex: Bunt Ludzkości pokazuje świat pełen nauki i techniki. Adam Jensen jest szefem ochrony w firmie Sarif Industries, która zajmuje się ulepszeniami biomechanicznymi dla ludzi. Rynek wszczepów jest opanowany przez kilka korporacji, ale wyższe dobro nie jest nadrzędnym celem dla wszystkich z nich.', NULL, NULL, '0', '0', '0', '0', '1', '1', '0'), (NULL, '2', NULL, '2', 'Recenzja', 'recenzja', NULL, 'Oryginalna muzyka z gry występuje w dwóch wersjach. Krótka próbka ścieżki dźwiękowej została dołączona w wersji cyfrowej do edycji kolekcjonerskiej gry oraz wydania Augmented Edition. Pełny album zawiera 25 utworów i został wydany 15 listopada 2015 roku.

Podsumowanie

Deus Ex: Bunt Ludzkości to świetna gra i równie dobry powrót do korzeni serii. Tytuł oferuje skradanie się, hakowanie, interakcje z postaciami i walkę podobnie jak oryginał. Równocześnie historia wykreowana przez twórców to całkiem prawdopodobny scenariusz. Korporacje walczące o wpływy, ludzie pragnący władzy i świat zagrożony postępem technologicznym nie są niemożliwe w przyszłości.

Pewien zarzut to monotonia pojawiająca się po wielu godzinach gry, kiedy kolejne hakowanie panelu zabezpieczającego lub komputera nie sprawia już masy przyjemności. Podobnie oglądanie znanych sekwencji obezwładnienia lub zabicia wrogów.', 'Oryginalna muzyka z gry występuje w dwóch wersjach. Krótka próbka ścieżki dźwiękowej została dołączona w wersji cyfrowej do edycji kolekcjonerskiej gry oraz wydania Augmented Edition. Pełny album zawiera 25 utworów i został wydany 15 listopada 2015 roku.

Podsumowanie

Deus Ex: Bunt Ludzkości to świetna gra i równie dobry powrót do korzeni serii. Tytuł oferuje skradanie się, hakowanie, interakcje z postaciami i walkę podobnie jak oryginał. Równocześnie historia wykreowana przez twórców to całkiem prawdopodobny scenariusz. Korporacje walczące o wpływy, ludzie pragnący władzy i świat zagrożony postępem technologicznym nie są niemożliwe w przyszłości.

Pewien zarzut to monotonia pojawiająca się po wielu godzinach gry, kiedy kolejne hakowanie panelu zabezpieczającego lub komputera nie sprawia już masy przyjemności. Podobnie oglądanie znanych sekwencji obezwładnienia lub zabicia wrogów.', NULL, NULL, '0', '0', '0', '0', '1', '1', '0');

-- story categories
INSERT INTO `renaissance-dev`.`story_category` (`id_story_category`, `name`, `slug`, `abbr`, `creation_date`, `modification_date`, `idx`, `visible`, `deleted`) VALUES 
(NULL, 'Fanfiki', 'fanfiki', 'fanfiction', '2004-06-24 14:15:16', NULL, 0, 1, 0),
(NULL, 'Artykuły', 'artykuly', 'article', '2004-06-28 12:11:08', NULL, 0, 1, 0),
(NULL, 'Wywiady', 'wywiady', 'interview', '2004-06-28 12:11:08', NULL, 0, 1, 0),
(NULL, 'Relacje', 'relacje', 'relation', '2004-06-28 12:11:08', NULL, 0, 1, 0);

-- stories
INSERT INTO `renaissance-dev`.`story` (`id_story`, `id_story_category`, `id_article_category`, `id_author`, `id_template`, `title`, `slug`, `old_url`, `markup`, `markdown`, `creation_date`, `modification_date`, `rated`, `sum`, `views`, `idx`, `verified`, `visible`, `deleted`) VALUES (NULL, '1', NULL, '2', NULL, 'Hitman rządzi', 'hitman-rzadzi', NULL, 'Targi E3 w tym roku przyniosły kilka ważnych informacji o nadchodzących grach. Fani Agenta 47 oczekiwali konkretów od Square Enix, które już wcześniej ogłosiło tworzenie przygód Hitmana

Studio IO Interactive ujawniło w trakcie targów zwiastun oraz fragmenty rozgrywki. Nowy Hitman zapowiada się bardzo dobrze, a twórcy zdradzili jeszcze więcej ważnych szczegółów.

Większość fanów zgadza się, że Hitman: Blood Money z 2006 roku był najlepszą częścią tej serii. Ostatnia część, czyli Rozgrzeszenie miała pozytywny odbiór, jednak do ideału trochę zabrakło, szczególnie z perspektywy czasu.', 'Targi E3 w tym roku przyniosły kilka ważnych informacji o nadchodzących grach. Fani Agenta 47 oczekiwali konkretów od Square Enix, które już wcześniej ogłosiło tworzenie przygód Hitmana

Studio IO Interactive ujawniło w trakcie targów zwiastun oraz fragmenty rozgrywki. Nowy Hitman zapowiada się bardzo dobrze, a twórcy zdradzili jeszcze więcej ważnych szczegółów.

Większość fanów zgadza się, że Hitman: Blood Money z 2006 roku był najlepszą częścią tej serii. Ostatnia część, czyli Rozgrzeszenie miała pozytywny odbiór, jednak do ideału trochę zabrakło, szczególnie z perspektywy czasu.', NULL, NULL, '0', '0', '0', '0', '0', '1', '0'), (NULL, '1', NULL, '5', NULL, 'Dominacja zachodnich RPG', 'dominacja-zachodnich-rpg', NULL, 'Poprzednie generacje konsol miały świetnych przedstawicieli zarówno po stronie sprzętu, jak i gier. Japońskie RPG królowały na konsolach takich jak NES, SNES czy PlayStation. Wprawdzie komputery stacjonarne oferowały gry pokroju Baldur''s Gate czy seria Ultima przed laty, ale to właśnie japońskie podejście do tematu przebiło się do świadomości graczy najbardziej. Zachodnie i japońskie RPG przez wiele lat określały różnice w grach między komputerami i konsolami.', 'Poprzednie generacje konsol miały świetnych przedstawicieli zarówno po stronie sprzętu, jak i gier. Japońskie RPG królowały na konsolach takich jak NES, SNES czy PlayStation. Wprawdzie komputery stacjonarne oferowały gry pokroju Baldur''s Gate czy seria Ultima przed laty, ale to właśnie japońskie podejście do tematu przebiło się do świadomości graczy najbardziej. Zachodnie i japońskie RPG przez wiele lat określały różnice w grach między komputerami i konsolami.', NULL, NULL, '0', '0', '0', '0', '0', '1', '0');

-- news
INSERT INTO `renaissance-dev`.`news` (`id_news`, `id_author`, `title`, `slug`, `origin`, `old_url`, `markup`, `markdown`, `creation_date`, `modification_date`, `comments`, `verified`, `visible`, `deleted`) VALUES (NULL, '3', 'Starting is awesome', 'starting-is-awesome', '', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in mi mollis, ultrices lectus eget, mollis sem. Vestibulum non tellus a nisl consequat sollicitudin eget sed lectus. Quisque nec magna convallis, sodales velit ut, suscipit nulla. Quisque massa enim, vehicula ac velit quis, sodales iaculis nisl. Maecenas in massa sit amet risus condimentum venenatis ut eu nibh. Ut hendrerit quis lacus in euismod. Pellentesque nec mauris vel elit porttitor accumsan non nec ex. Suspendisse volutpat blandit felis in porta. Nulla facilisi. Aenean id erat vel ligula elementum sodales eget in odio. In magna sapien, ultricies eget libero in, feugiat consectetur lacus. Donec in arcu in arcu consectetur auctor. Nunc ultricies maximus odio, sit amet gravida urna. Fusce at mollis neque, sed placerat neque.

Suspendisse placerat arcu ut magna tristique faucibus. In fringilla nulla neque, id semper leo imperdiet at. Curabitur placerat blandit est, at sollicitudin risus. Curabitur vel tellus vitae odio finibus iaculis sit amet sit amet ex. Nunc consectetur eros ut diam feugiat, tristique vestibulum est suscipit. Nunc rutrum leo ac dolor consectetur ultricies. Proin sed urna ut mauris luctus ultrices. Praesent vel maximus libero, eget finibus enim. Nullam erat ante, feugiat vel viverra vitae, blandit ac neque. Quisque tristique gravida est. Suspendisse nec lacinia est, nec lacinia mi. Nulla egestas risus vitae porttitor placerat. Aenean tristique et nunc eu scelerisque. Mauris in purus lectus. Praesent lacus dolor, sodales ac mollis quis, congue varius erat.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in mi mollis, ultrices lectus eget, mollis sem. Vestibulum non tellus a nisl consequat sollicitudin eget sed lectus. Quisque nec magna convallis, sodales velit ut, suscipit nulla. Quisque massa enim, vehicula ac velit quis, sodales iaculis nisl. Maecenas in massa sit amet risus condimentum venenatis ut eu nibh. Ut hendrerit quis lacus in euismod. Pellentesque nec mauris vel elit porttitor accumsan non nec ex. Suspendisse volutpat blandit felis in porta. Nulla facilisi. Aenean id erat vel ligula elementum sodales eget in odio. In magna sapien, ultricies eget libero in, feugiat consectetur lacus. Donec in arcu in arcu consectetur auctor. Nunc ultricies maximus odio, sit amet gravida urna. Fusce at mollis neque, sed placerat neque.

Suspendisse placerat arcu ut magna tristique faucibus. In fringilla nulla neque, id semper leo imperdiet at. Curabitur placerat blandit est, at sollicitudin risus. Curabitur vel tellus vitae odio finibus iaculis sit amet sit amet ex. Nunc consectetur eros ut diam feugiat, tristique vestibulum est suscipit. Nunc rutrum leo ac dolor consectetur ultricies. Proin sed urna ut mauris luctus ultrices. Praesent vel maximus libero, eget finibus enim. Nullam erat ante, feugiat vel viverra vitae, blandit ac neque. Quisque tristique gravida est. Suspendisse nec lacinia est, nec lacinia mi. Nulla egestas risus vitae porttitor placerat. Aenean tristique et nunc eu scelerisque. Mauris in purus lectus. Praesent lacus dolor, sodales ac mollis quis, congue varius erat.', '2015-09-16 18:22:59', NULL, '1', '0', '1', '0'), (NULL, '3', 'More and more', 'more-and-more', '', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in mi mollis, ultrices lectus eget, mollis sem. Vestibulum non tellus a nisl consequat sollicitudin eget sed lectus. Quisque nec magna convallis, sodales velit ut, suscipit nulla. Quisque massa enim, vehicula ac velit quis, sodales iaculis nisl. Maecenas in massa sit amet risus condimentum venenatis ut eu nibh. Ut hendrerit quis lacus in euismod. Pellentesque nec mauris vel elit porttitor accumsan non nec ex. Suspendisse volutpat blandit felis in porta. Nulla facilisi. Aenean id erat vel ligula elementum sodales eget in odio. In magna sapien, ultricies eget libero in, feugiat consectetur lacus. Donec in arcu in arcu consectetur auctor. Nunc ultricies maximus odio, sit amet gravida urna. Fusce at mollis neque, sed placerat neque.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in mi mollis, ultrices lectus eget, mollis sem. Vestibulum non tellus a nisl consequat sollicitudin eget sed lectus. Quisque nec magna convallis, sodales velit ut, suscipit nulla. Quisque massa enim, vehicula ac velit quis, sodales iaculis nisl. Maecenas in massa sit amet risus condimentum venenatis ut eu nibh. Ut hendrerit quis lacus in euismod. Pellentesque nec mauris vel elit porttitor accumsan non nec ex. Suspendisse volutpat blandit felis in porta. Nulla facilisi. Aenean id erat vel ligula elementum sodales eget in odio. In magna sapien, ultricies eget libero in, feugiat consectetur lacus. Donec in arcu in arcu consectetur auctor. Nunc ultricies maximus odio, sit amet gravida urna. Fusce at mollis neque, sed placerat neque.', NULL, NULL, '1', '0', '1', '0');

-- news comments
INSERT INTO `renaissance-dev`.`news_comment` (`id_news_comment`, `id_news`, `id_author`, `comment`, `creation_date`, `visible`) VALUES 
(NULL, '1', '2', 'wno po stronie sprzętu, jak i gier. Japońskie RPG ', NULL, '1'),
(NULL, '2', '1', 'ólowały na konsolach takich jak NES, SNES czy PlayStation. Wprawdzie komputery stacjonarne oferowały gry pokroju ', NULL, '1'),
(NULL, '1', '2', 'óżnice w grach między komputerami i konsolami.', NULL, '1'),
(NULL, '3', '4', 'ócą do świetności sprzed lat.', NULL, '1'),
(NULL, '4', '2', 'órcom podobieństwo do zachodnich produkcji.', NULL, '1'),
(NULL, '1', '5', 'ów gatunku, ale taka zmiana jest zaskakująca. ', NULL, '1'),
(NULL, '2', '6', 'ówne czynniki powodujące te zmiany. Pierwszy z nich to brak przygotowania japońskiego przemysłu do ', NULL, '1'),
(NULL, '3', '1', 'ód to wkroczenie na konsole wielkiego gracza jakim jest Microsoft.', NULL, '1'),
(NULL, '1', '2', 'ów. Aspekt HD dotknął produkty Square Enix w ogromnym stopniu. Nie ', NULL, '1'),
(NULL, '4', '8', 'ódmej generacji. Tworzenie gier HD było bardzo drogie i ', NULL, '1'),
(NULL, '1', '3', 'óstej generacji. Debiut konsoli ', NULL, '1'),
(NULL, '1', '7', 'ów. Opóźniona premiera i brak wsparcia znanych wydawców były znaczące. Microsoft ', NULL, '1');









