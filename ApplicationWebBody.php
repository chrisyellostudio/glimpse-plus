<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplicationWebBody
 *
 * @author MSI
 */
class ApplicationWebBody {
    public $currentBranch;
    public $breadArray;
    public $bodyTitle;
    public $bodyContent;
    public $rightTitle;
    public $rightContentLinks;
    public $leftTitle;
    public $leftContent;
    
    public function __construct($ttitle, $bodyContent) {
        $t = $this->bodytitle;
        $cB = $this->bodyContent;
    }
    
    public function setCurrentBranch($branch){
        $this->currentBranch = $branch;
    }
    
    public function getCurrentBranch(){
        return $this->currentBranch;
    }
    
    public function setbreadArray($array){
        $this->breadArray = $array;
    }
    
    public function getbreadArray(){
        return $this->breadArray;
    }
    
    public function setBodyTitle($title){
        $this->bodyTitle = $title;
    }
    
    public function getBodyTitle(){
        return $this->bodyTitle;
    }
}

?>
