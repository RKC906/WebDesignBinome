-- Insérer les catégories
INSERT INTO categories (nom, slug, description) VALUES
('Politique', 'politique', 'Actualités politiques relatives à l''Iran et la région'),
('Militaire', 'militaire', 'Informations sur les opérations et tensions militaires'),
('Économie', 'economie', 'Situation économique et sanctions'),
('Diplomatie', 'diplomatie', 'Négociations et relations internationales'),
('Société', 'societe', 'Vie sociale et culturelle')
ON CONFLICT DO NOTHING;

-- Insérer les auteurs
INSERT INTO auteurs (nom, prenom, bio) VALUES
('Dupont', 'Jean', 'Journaliste spécialisé en géopolitique du Moyen-Orient'),
('Martin', 'Marie', 'Correspondante à Téhéran depuis 2020'),
('Bernard', 'Pierre', 'Analyste politique et économique')
ON CONFLICT DO NOTHING;

-- Insérer les administrateurs
-- Compte de démo pour le développement
-- username: cedy
-- password: cedy123
INSERT INTO admin (username, password, email) VALUES
('cedy', 'cedy123', 'cedy@gmail.com')
ON CONFLICT DO NOTHING;

-- Insérer les articles
INSERT INTO articles (titre, slug, contenus, description, image_url, author_id, category_id, published) VALUES
(
    'Nouvelles tensions diplomatiques en Iran',
    'nouvelles-tensions-diplomatiques-iran',
    'Les dernières négociations entre l''Iran et les puissances occidentales ont atteint un impasse. Les discussions sur le programme nucléaire iranien continuent de susciter des préoccupations internationales. Les diplomates des deux côtés tentent de trouver un terrain d''entente avant la fin du trimestre.',
    'Les négociations diplomatiques s''intensifient au sujet du programme nucléaire',
    '/uploads/articles/1.jpeg',
    1,
    4,
    true
),
(
    'Impact économique des sanctions internationales',
    'impact-economique-sanctions-internationales',
    'L''économie iranienne continue de subir les effets des sanctions économiques imposées par les puissances occidentales. L''inflation reste élevée et la valeur du rial iranien a connu une baisse significative. Les entreprises iraniennes cherchent des alternatives commerciales avec d''autres pays.',
    'Les sanctions économiques pèsent lourdement sur l''économie iranienne',
    '/uploads/articles/1.jpeg',
    2,
    3,
    true
),
(
    'Mouvements politiques et réformes internes',
    'mouvements-politiques-reformes-internes',
    'Des mouvements de réforme politique gagnent du terrain en Iran. Les jeunes générations demandent plus de liberté et de transparence dans le processus politique. Des débats intenses se déroulent au sein des institutions gouvernementales sur la direction à prendre.',
    'La politique intérieure iranienne connaît une période de changements majeurs',
    '/uploads/articles/politique.jpeg',
    3,
    1,
    true
)
ON CONFLICT DO NOTHING;