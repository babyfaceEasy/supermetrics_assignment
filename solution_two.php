<?php

class RegisterData
{
    private string $token;

    private string $clientID;

    private string $email;

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return string|null
     */
    public function getClientID(): ?string
    {
        return $this->clientID;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return $this
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return $this
     */
    public function setClientID(string $clientID): self
    {
        $this->clientID = $clientID;
        return $this;
    }

    /**
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->type = $email;
        return $this;
    }
}

interface RegisterMapperInterface
{
    public function map(array $data): RegisterData;
}


class SupermetricsRegisterMapper implements RegisterMapperInterface
{
    public function map(array $data): RegisterData
    {
        $dto = (new RegisterData())
            ->setToken($data['token'])
            ->setClientID($data['client_id'])
            ->setEmail($data['email']);
            
        return $dto;
    }
}

interface HTTPClientInterface
{
    public function post(string $url, array $body): ?array;
}

class HTTPClient implements HTTPClientInterface
{
    public function post(string $url, array $body): ?array
    {
        $payload = json_encode($body);
        try{
            $ch = curl_init();

            if ($ch === false) {
                throw new \Exception('Failed to initialize cURL handler.');
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            if ($response === false) {
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }

            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            return json_decode($response);

        } catch(\Exception $e) {
            trigger_error(sprintf('Curl failed with the following error #%d: %s', $e->getCode(), $e->getMessage()), E_USER_ERROR);
        } finally {
            if (is_resource($ch)) {
                curl_close($ch);
            }
        }
    }
}

interface APIInterface
{
    public function register(array $parameters);
}

class SupermetricsGateway implements APIInterface
{
    private HTTPClientInterface $client;
    private RegisterMapperInterface $mapper;

    public function __construct(RegisterMapperInterface $mapper, HTTPClientInterface $client)
    {
        $this->mapper = $mapper;
        $this->client = $client;
    }

    public function register(array $parameters): RegisterData
    {
        //$url = "https://api.supermetrics.com/assignment/register";
        $url = getenv("SUPERMETRICS_REGISTER_URL");
        $data = $this->client->post($url, $parameters);
        return $this->mapper->map($data);
    }
}