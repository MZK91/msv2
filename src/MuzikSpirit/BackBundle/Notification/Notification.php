<?php

namespace MuzikSpirit\BackBundle\Notification;

use Symfony\Component\HttpFoundation\Session\Session;

class Notification{

    protected $session;

    public function __construct(Session $session){
        $this->session = $session;

    }

    /**
     * @param $message
     * @param string $criticity
     * criticity : success - danger - warning - info
     */

    public function notify($message, $criticity = "success") {
        // La fonction set va me mettre en session le message avec la clef alert
        $this->session->set('alert', array(
            'message' => $message,
            'criticity' => $criticity,
        ));
    }
}