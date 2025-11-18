<?php
abstract class View{
    protected array $request;
    protected string $req;
    public function __construct(array $request){
        $this->request = $request;
        $this->req = $request['req'] ?? "";
    }
    abstract protected function process(): void;
}