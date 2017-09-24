<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/9/6
 * Time: 07:31
 */
/**
 * 简单的说，可将WebSocket协议之前，双工通信是通过多个HTTP链接来实现，这导致了效率低下.WebSocket解决了这个问题。下面是标准RFC6455中的产生背景概述。
 * 历史上，创建需要客户端和服务器（例如即时消息和游戏应用程序）之间双向通信的Web应用程序需要滥用HTTP来轮询服务器进行更新，同时将上游通知作为不同的HTTP调用发送。
 * 这会导致各种问题：
 * o服务器被迫为每个客户端使用多个不同的底层TCP连接：一个用于向客户端发送信息，另一个用于每个传入消息。
 * o有线协议具有高开销，每个客户端到服务器的消息具有HTTP头。o客户端脚本被强制维护从传出连接到传入连接的跟踪以跟踪回复。
 * 一个更简单的解决方案是使用单个TCP连接来实现双向流量。这是WebSocket协议提供的。结合WebSocket API，它提供了从网页到远程服务器的双向通信的HTTP轮询的替代方法。
 * WebSocket协议旨在取代使用HTTP作为传输层的现有双向通信技术。这些技术被实现为效率和可靠性之间的权衡，因为HTTP最初并不用于双向通信（见[RFC6202]进一步讨论）。[1]
 * 长久以来，创建实现客户端和用户端之间双工通讯的web app都会造成HTTP轮询的滥用：客户端向主机不断发送不同的HTTP呼叫来进行询问。
 * 这会导致一系列的问题：
 * 1.服务器被迫为每个客户端使用许多不同的底层TCP连接：一个用于向客户端发送信息，其它用于接收每个传入消息。
 * 2.有线协议有很高的开销，每一个客户端和服务器之间都有HTTP头。
 * 3.客户端脚本被迫维护从传出连接到传入连接的映射来追踪回复。
 * 一个更简单的解决方案是使用单个TCP连接双向通信。这就是WebSocket协议所提供的功能。结合WebSocket API，WebSocket协议提供了一个用来替代HTTP轮询实现网页到远程主机的双向通信的方法。
 * 网页套接字协议被设计来取代用HTTP作为传输层的双向通讯技术，这些技术只能牺牲效率和可依赖性其中一方来提高另一方，因为HTTP最初的目的不是为了双向通讯。（获得更多关于此的讨论可查阅RFC6202）
 *
 * 实现原理
 * 在实现websocket连线过程中，需要通过浏览器发出websocket连线请求，然后服务器发出回应，这个过程通常称为“握手”。在WebSocket API中，浏览器和服务器只需要做一个握手的动作，然后，浏览器和服务器之间就形成了一条快速通道。两者之间就直接可以数据互相传送。在此WebSocket协议中，为我们实现即时服务带来了两大好处：
 * 标题
 * 互相沟通的头是很小的 - 大概只有2字节
 * 2.服务器推送
 * 服务器的推送，服务器不再被动的接收到浏览器的请求之后才返回数据，而是在有新数据时就主动推送给浏览器。
 * */


/**
 * 聊天室服务器  websocket 专用
 */


class Server_socket
{
    private $socket;
    private $accept = [];
    private $hands = [];
    function __construct($host, $port, $max)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, TRUE);
        socket_bind($this->socket, $host,$port);
        socket_listen($this->socket,$max);
        print_r($this->socket);
    }

    public function start()
    {
        while (true) {

            $cycle = $this->accept;
            $cycle[] = $this->socket;
            socket_select($cycle, $write, $except, null);

            foreach ($cycle as $sock) {
                if ($sock == $this->socket) {
                    $this->accept[] = socket_accept($sock);
                    $arr =  array_keys($this->accept);
                    $key = end($arr);
                    $this->hands[$key] = false;

                }else{
                    $length = socket_recv($sock, $buffer, 204800, null);
                    $key = array_search($sock, $this->accept);
                    if (!$this->hands[$key]) {
                        $this->dohandshake($sock,$buffer,$key);
                    }else if($length < 1){
                        $this->close($sock);
                    }else{

                       /* for($i=0;$i<30;$i++) {
                            $data = $i;
                            $data = $this->encode($data);

                            //  file_put_contents('a.txt','data'.json_encode($data),FILE_APPEND);
                            //发送
                            foreach ($this->accept as $client) {
                                socket_write($client, $data,strlen($data));
                            }
                        }*/
                          /* $redis = new Redis();
                           $redis->connect('localhost');
                            $data = $redis->lPop('hello2');
                            $data = $this->encode($data);
                            print_r($data);*／
                            //  file_put_contents('a.txt','data'.json_encode($data),FILE_APPEND);
                            //发送
                            foreach ($this->accept as $client) {
                                socket_write($client, $data, strlen($data));
                            }
                        }
                            /*
                            }
*/
                            // 解码
                            $data = $this->decode($buffer);
                        parse_str($data,$data2);

                         //   file_put_contents('a.txt',var_export($data2,1),FILE_APPEND);
                            //print_r($data2);
                            $data = json_encode($data2);
                            //编码
                            $data = $this->encode($data);
                          //  print_r($data);
                            //  file_put_contents('a.txt','data'.json_encode($data),FILE_APPEND);
                            //发送
                            foreach ($this->accept as $client) {
                                socket_write($client, $data,strlen($data));
                            }
                    }
                }
            }
            sleep(1);
        }
    }/* end of start*/

    /**
     * 首次与客户端握手
     */
    public function dohandshake($sock, $data, $key) {
        if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $data, $match)) {
            $response = base64_encode(sha1($match[1] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
            $upgrade  = "HTTP/1.1 101 Switching Protocol\r\n" .
                "Upgrade: websocket\r\n" .
                "Connection: Upgrade\r\n" .
                "Sec-WebSocket-Accept: " . $response . "\r\n\r\n";
            socket_write($sock, $upgrade, strlen($upgrade));
            $this->hands[$key] = true;
        }
    }/*dohandshake*/

    /**
     * 关闭一个客户端连接
     */
    public function close($sock) {
        $key = array_search($sock, $this->accept);
        socket_close($sock);
        unset($this->accept[$key]);
        unset($this->hands[$key]);
    }

    /**
     * 字符解码
     */
    public function decode($buffer) {
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;
        if ($len === 126) {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        }
        else if ($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        }
        else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }
        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return $decoded;
    }

    /**
     * 字符编码
     */
    public function encode($buffer) {
        $length = strlen($buffer);
        if($length <= 125) {
            return "\x81".chr($length).$buffer;
        } else if($length <= 65535) {
            return "\x81".chr(126).pack("n", $length).$buffer;
        } else {
            return "\x81".char(127).pack("xxxxN", $length).$buffer;
        }
    }

}/* end of class Server_socket*/

$server_socket = new Server_socket('127.0.0.1',8008,1000);
$server_socket->start();