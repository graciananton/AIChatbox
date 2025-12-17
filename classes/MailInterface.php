<?php
interface MailInterface {
    public function sendMessage(Contact $Contact):bool;
    public function setHeader():array;
}