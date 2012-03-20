<?php

/**
 * 
 *
 * @author cir8
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
    
    /*
     * Basic constructor for the application web body object.
     */
    public function __construct($title, $bodyContent) {
        $title = $this->bodytitle;
        $bodyContent = $this->bodyContent;
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
    
    public function setBodyContents($content){
        $this->bodyContent = $content;
    }
    
    public function getBodyContents(){
        return $this->bodyContent;
    }
    
    public function setRightTitle($title){
        $this->rightTitle = $title;
    }
    
    public function getRightTitle(){
        return $this->rightTitle;
    }
    
    public function setRightContentLinks($links){
        $this->rightContentLinks = $links;
    }
    
    public function getRightContentLinks(){
        return $this->rightContentLinks;
    }
    
    public function setLeftTitle($title){
        $this->leftTitle = $title;
    }
    
    public function getLeftTitle(){
        return $this->leftTitle;
    }
    
    public function setLeftContent($content){
        $this->leftContent = $content;
    }
    
    public function getLeftContent(){
        return $this->leftContent;
    }
}
?>
