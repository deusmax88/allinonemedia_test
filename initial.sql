CREATE SCHEMA allinonemedia;

CREATE TABLE allinonemedia.authors
(
  id SERIAL PRIMARY KEY,
  name VARCHAR(255)
);

INSERT INTO allinonemedia.authors(name) VALUES
  ('CrazyNews'),
  ('Чук и Гек'),
  ('CatFuns'),
  ('CarDriver'),
  ('BestPics'),
  ('ЗОЖ'),
  ('Вася Пупкин'),
  ('Готовим со вкусом'),
  ('Шахтёрская Правда'),
  ('FunScience')
;

CREATE TABLE allinonemedia.languages
(
  id SERIAL PRIMARY KEY,
  name VARCHAR(255)
);

INSERT INTO allinonemedia.languages(name) VALUES
  ('Русский'),
  ('English')
;

CREATE TABLE allinonemedia.posts
(
  id SERIAL PRIMARY KEY,
  language_id INT NOT NULL,
  author_id INT NOT NULL,
  publication_date DATE NOT NULL,
  heading VARCHAR(255) NOT NULL,
  text VARCHAR(1023) NOT NULL,
  num_of_likes INT NOT NULL
);


ALTER TABLE allinonemedia.posts
  ADD CONSTRAINT posts_authors_id_fk
FOREIGN KEY (author_id) REFERENCES allinonemedia.authors (id) ON DELETE CASCADE;

ALTER TABLE allinonemedia.posts
  ADD CONSTRAINT posts_languages_id_fk
FOREIGN KEY (language_id) REFERENCES allinonemedia.languages (id) ON DELETE CASCADE;