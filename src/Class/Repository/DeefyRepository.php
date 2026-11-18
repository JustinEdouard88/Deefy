<?php

namespace iutnc\deefy\repository;

class DeefyRepository {

    private \PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf) {
        $this->pdo = new \PDO(
            $conf['dsn'],
            $conf['user'],
            $conf['pass'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function getInstance(): DeefyRepository {
        if (is_null(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file): void {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }

        $dsn = "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']};charset=utf8mb4";

        self::$config = [
            'dsn'  => $dsn,
            'user' => $conf['username'],
            'pass' => $conf['password']
        ];
    }

    
    public function getPlaylistById(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM playlist WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllPlaylists(): array {
        $stmt = $this->pdo->query("SELECT * FROM playlist");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addPlaylist(string $name): int {
        $stmt = $this->pdo->prepare("INSERT INTO playlist (nom) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        return (int)$this->pdo->lastInsertId();
    }

    public function addTrack(string $titre, string $genre, int $duree, string $filename, int $playlist_id): void {
        $stmt = $this->pdo->prepare("INSERT INTO track (titre, genre, duree, filename) VALUES (:titre, :genre, :duree, :filename)");
        $stmt->execute([
            'titre' => $titre,
            'genre' => $genre,
            'duree' => $duree,
            'filename' => $filename
        ]);

        $this->addTrackToPlaylist((int)$this->pdo->lastInsertId(), $playlist_id);
    }

    public function getTrackById(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM track WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addTrackToPlaylist(int $trackId, int $playlistId): void {
        $stmtCount = $this->pdo->prepare("SELECT COUNT(*) FROM playlist2track WHERE id_pl = :playlist_id");
        $stmtCount->execute(['playlist_id' => $playlistId]);
        $noPiste = (int)$stmtCount->fetchColumn() + 1;

        $stmt = $this->pdo->prepare(
            "INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (:playlist_id, :track_id, :no_piste)"
        );
        $stmt->execute([
            'playlist_id' => $playlistId,
            'track_id'    => $trackId,
            'no_piste'    => $noPiste
        ]);
    }

    public function getTracksByPlaylistId(int $playlistId): array {
        $stmt = $this->pdo->prepare(
            "SELECT t.* FROM track t
             JOIN playlist2track p2t ON t.id = p2t.id_track
             WHERE p2t.id_pl = :playlist_id
             ORDER BY p2t.no_piste_dans_liste"
        );
        $stmt->execute(['playlist_id' => $playlistId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}