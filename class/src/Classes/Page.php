<?php

namespace Students\Classes;

use Rain\Tpl;
use Students\Classes\Register;

class Page {

    private $tpl;
    private $options = [];
    private $defaults = [
        "header"=>true,
        "headerAluno"=>true,
        "headerProf"=>true,
        "footer"=>true,
        "data"=>[]
    ];

    public function __construct($opts = array()){
        $this->options = array_merge($this->defaults, $opts);
        $config = array(
            "tpl_dir"=>$_SERVER["DOCUMENT_ROOT"]."/"."views/",
            "cache_dir"=>$_SERVER["DOCUMENT_ROOT"]."/"."views-cache/",
            "debug"=>false
        );
        Tpl::configure($config);
        $this->tpl = new Tpl;
        $this->setData($this->options["data"]);
        //pega só o 1º nome
        if(isset($_SESSION["user"]["desnome"])){
            
            $desnomea = $_SESSION["user"]["desnome"];
            $results = explode(" ", $desnomea);
        }
        if(isset($_SESSION["userProf"]["desnome"])){
            $desnomep = $_SESSION["userProf"]["desnome"];
            $professor = explode(" ", $desnomep);
        }
        //images
        if(!isset($photop)){
            $photoa = "";
        }
        if(isset($_SESSION["user"]["desimage"])){
            $photoa = $_SESSION["user"]["desimage"];
        }

        if(isset($_SESSION["userProf"]["desimage"])){
            $photop = $_SESSION["userProf"]["desimage"];
        }
        if ($this->options["header"] === true) $this->setTpl("header");
        if ($this->options["headerAluno"] === true) $this->setTpl("headerAluno", [
            "aluno"=>$results[0],
            "photo"=>$photoa
        ]);
        if(!isset($photop)){
            $photop = "";
        }
        if ($this->options["headerProf"] === true) $this->setTpl("headerProf", [
            "professor"=>$professor[0],
            "photo"=>$photop
        ]);
    }

    public function setData($data = array()){
        foreach ($data as $key => $value){
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data = array(), $returnHTML = false){
        $this->setData($data);
       return $this->tpl->draw($name, $returnHTML);
    }

    public function __destruct(){
        if ($this->options["footer"] === true) $this->tpl->draw("footer");
    }

}