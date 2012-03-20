<?php


/**
 * Description of Introduction
 *
 * @author cir8
 */


class Introduction {
    public $bodyContent = '';
    
    public function createPage(){
        $body = new ApplicationWebBody('Introduction', $bodyContent);
        $body->setCurrentBranch('home');
        $body->getbreadArray(array('Home','Introduction'));
                
    }
}

?>
