DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
    `email` varchar(128) NOT NULL,
    `nom` varchar(128),
    `prenom` varchar(128),
    `adresse` varchar(128),
    `numero` int(11),
    `date` date,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS comment;
CREATE TABLE `comment` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `title` varchar(128) NOT NULL,
                        `content` varchar(128),
                        `created_at` DATETIME,
                        `updated_at` DATETIME,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS comment2game;
CREATE TABLE `comment2game` (
                           `comment_id` int(11) NOT NULL ,
                           `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS comment2user;
CREATE TABLE `comment2user` (
                                `comment_id` int(11) NOT NULL ,
                                `user_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

commit;