<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120416152406 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

        $this->addSql("ALTER TABLE club_match_game_user DROP FOREIGN KEY FK_6021C410E48FD905");
        $this->addSql("ALTER TABLE club_match_match DROP FOREIGN KEY FK_1AC3E22FE48FD905");
        $this->addSql("CREATE TABLE club_match_league (id INT AUTO_INCREMENT NOT NULL, rule_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, invite_only TINYINT(1) NOT NULL, game_set INT NOT NULL, type VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E56F92E9744E0351 (rule_id), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE club_match_league_user (league_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_82B9A16758AFC4DE (league_id), INDEX IDX_82B9A167A76ED395 (user_id), PRIMARY KEY(league_id, user_id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE club_match_league ADD CONSTRAINT FK_E56F92E9744E0351 FOREIGN KEY (rule_id) REFERENCES club_match_rule(id)");
        $this->addSql("ALTER TABLE club_match_league_user ADD CONSTRAINT FK_82B9A16758AFC4DE FOREIGN KEY (league_id) REFERENCES club_match_league(id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE club_match_league_user ADD CONSTRAINT FK_82B9A167A76ED395 FOREIGN KEY (user_id) REFERENCES club_user_user(id) ON DELETE CASCADE");
        $this->addSql("DROP TABLE club_match_game");
        $this->addSql("DROP TABLE club_match_game_user");
        $this->addSql("DROP INDEX IDX_1AC3E22FE48FD905 ON club_match_match");
        $this->addSql("ALTER TABLE club_match_match CHANGE game_id league_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE club_match_match ADD CONSTRAINT FK_1AC3E22F58AFC4DE FOREIGN KEY (league_id) REFERENCES club_match_league(id)");
        $this->addSql("CREATE INDEX IDX_1AC3E22F58AFC4DE ON club_match_match (league_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

        $this->addSql("ALTER TABLE club_match_match DROP FOREIGN KEY FK_1AC3E22F58AFC4DE");
        $this->addSql("ALTER TABLE club_match_league_user DROP FOREIGN KEY FK_82B9A16758AFC4DE");
        $this->addSql("CREATE TABLE club_match_game (id INT AUTO_INCREMENT NOT NULL, rule_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, invite_only TINYINT(1) NOT NULL, game_set INT NOT NULL, type VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B82CE13744E0351 (rule_id), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE club_match_game_user (game_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6021C410E48FD905 (game_id), INDEX IDX_6021C410A76ED395 (user_id), PRIMARY KEY(game_id, user_id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE club_match_game ADD CONSTRAINT FK_B82CE13744E0351 FOREIGN KEY (rule_id) REFERENCES club_match_rule(id)");
        $this->addSql("ALTER TABLE club_match_game_user ADD CONSTRAINT FK_6021C410A76ED395 FOREIGN KEY (user_id) REFERENCES club_user_user(id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE club_match_game_user ADD CONSTRAINT FK_6021C410E48FD905 FOREIGN KEY (game_id) REFERENCES club_match_game(id) ON DELETE CASCADE");
        $this->addSql("DROP TABLE club_match_league");
        $this->addSql("DROP TABLE club_match_league_user");
        $this->addSql("ALTER TABLE club_match_match DROP FOREIGN KEY FK_1AC3E22F58AFC4DE");
        $this->addSql("DROP INDEX IDX_1AC3E22F58AFC4DE ON club_match_match");
        $this->addSql("ALTER TABLE club_match_match CHANGE league_id game_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE club_match_match ADD CONSTRAINT FK_1AC3E22FE48FD905 FOREIGN KEY (game_id) REFERENCES club_match_game(id)");
        $this->addSql("CREATE INDEX IDX_1AC3E22FE48FD905 ON club_match_match (game_id)");
    }
}
