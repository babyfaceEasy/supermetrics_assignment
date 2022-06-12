<?php

declare (strict_types = 1);

class Request
{
    private array $data;

    public function __construct()
    {
        $this->data = $_REQUEST;
    }

    /**
     * @var string|null
     */
    public function getMasterEmail(): ?string
    {
        if ($this->data['email']) $masterEmail = $this->data['email'];

        $masterEmail = (isset($masterEmail) && $masterEmail) ? $masterEmail : (array_key_exists('masterEmail', $this->data) && $this->data["masterEmail"])
            ? $_REQUEST['masterEmail'] : 'unknown';
        echo 'The master email is ' . $masterEmail . '\n';
        return $masterEmail;
    }
}

class DBConnector {

    private PDO $dbConnection;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        try {

            $this->dbConnection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user, $pass
            );
        } catch(PDOException $e) {
            // TODO: should log the error instead of crashing the app
            exit($e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->dbConnection;
    }
}

interface UserRepositoryInterface
{
    /**
     * @return string|null
     */
    public function getUsernameByEmail(string $email): ?string;
}

class UserRepository implements UserRepositoryInterface
{

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @return string|null
     */
    public function getUsernameByEmail(string $email): ?string
    {
        $query = "SELECT * FROM users WHERE email = ?;";

        try {
            $statement = $this->db->prepare($query);
            $statement->execute(array($email));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($result === false) {
                return null;
            }

            return $result['username'];
        } catch(PDOException $e) {
            // TODO: should log the error instead of crashing the app
            exit($e->getMessage());
        }

    }

}