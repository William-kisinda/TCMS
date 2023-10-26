<?php

namespace App\Http\Controllers\Tcms\TokenGeneration\Config;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection
{

    /**
     * @author Daniel.
     *
     * @param null
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */

    protected $connection;
    protected $channel;

    public function __construct() {
        $this->connection = new AMQPStreamConnection(env('RABBITMQ_HOST'), env('RABBITMQ_PORT'), env('RABBITMQ_LOGIN'), env('RABBITMQ_PASSWORD'));
        $this->channel = $this->connection->channel();
    }

    public function getConnectionChannel() {
        return $this->channel;
    }

    public function createConnection()
    {
        try {
            // $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
            $this->channel = $this->connection->channel();
        } catch (\Exception $exception) {
            Log::info("Connection Failed::" . $exception->getMessage());
            die('Connection failed');
        }
    }

    public function closeConnection() {
        if($this->connection) {
            $this->connection->close();
        }
    }
}
