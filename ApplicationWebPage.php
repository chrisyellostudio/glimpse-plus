<?php

/**
 * Description of ApplicationWebPage
 *
 * @author cir8
 */

define('APPLICATION_HEADER', 'GLimPSE');
define("APPLICATION_TITLE", APPLICATION_HEADER . " :: ");
define("DEFAULT_STYLE", 'styles.css');

class ApplicationWebPage {
   
    public function head($title, $styleArray = '', $script = '') {
        $title = APPLICATION_TITLE . $title;
        $head = '';
        $head .= '<!doctype html>
                <html>
                    <head>
                        <title>' . $title . '</title>
                        <link rel="stylesheet" href="html/' . DEFAULT_STYLE . '">';
        if (sizeof($styleArray)>1) {
            foreach ($styleArray as $style) {
                $head .= '<link rel="stylesheet" href="html/' . $stlye . '">';
            }
        }
        if (isset($script)) {
            $head .= '<script type="text/javascript">' . $script . '</script>';
        }
        $head .= '</head> ';

        echo $head;
    }

    public function navigation($currentBranch) {
        $home = $about = $search = $acc = $nav = '';

        if ($currentBranch == "home") {
            $home = 'class="selected"';
        } elseif ($currentBranch == "about") {
            $about = 'class="selected"';
        } elseif ($currentBranch == "search") {
            $search = 'class="selected"';
        } elseif ($currentBranch == "account") {
            $acc = 'class="selected"';
        }

        $nav .= '<nav>
                <ul>
                    <li><a ' . $home . 'href="index.php">Home</a></li>
                    <li><a ' . $about . 'href="about.php">About</a></li>
                    <li><a ' . $search . 'href="search.php">Search</a></li>
                    <li><a ' . $acc . 'href="account.php">My Account</a></li>
                </ul>
             </nav>';
        
        echo $nav;
    }

    public function breadcrumbs($breadArray) {
        $breadcrumbs = '';
        $breadcrumbs .= '<div class="currentlocation">';
        $breadcrumbs .= '<p>' . implode(' > ', $breadArray) . '</p>';
        $breadcrumbs .= '</div>';

        return $breadcrumbs;
    }

    public function body(ApplicationWebBody $bodyObject) {
        $body = '';
        $body .= '<header>
                <h1>' . APPLICATION_HEADER . '</h1>
              </header>';
        $body .= $this->navigation($bodyObject->getCurrentBranch());
        $body .= $this->breadcrumbs($bodyObject->getbreadArray());
        $body .= '<div id="contentWrapper">';
        $body .= $this->leftSidebar($bodyObject->getLeftTitle(), $bodyObject->getLeftContent());
        $body .= '<section class="content">
                    <h1>' . $bodyObject->getBodyTitle() . '</h1>       
                        ' . $bodyObject->getBodyContents() . '
                </section>';
        $body .= $this->rightSidebar($bodyObject->getRightTitle(), $bodyObject->getRightContentLinks());
        $body .='</div> ';
        
        return $body;
    }

    /*
     * Creates the right hand side bar on the web page.
     * 
     * @param string $title 
     * @param array $contentLinks
     * @return string $rightSide
     *      Returns a string containing the html for the sidebar
     */
    public function rightSidebar($title, $contentLinks) {
        $rightSide = '';
        $rightSide .= '<sidebar>
                <section>
                    <header><h1>' . $title . '</h1></header>
                    <ul>
                    ';
        foreach ($contentLinks as $link => $value) {
            $rightSide .= '<li><a href="' . $link . '">' . $value . '</a></li>';
        }
        $rightSide .= '</ul>
                </section>
             </sidebar>';

        return $rightSide;
    }

    public function leftSidebar($title, $content) {
        $leftSide = '';
        if($title || $content != ''){
        $leftSide .= '<sidebar>
                <section>
                    <header><h1>' . $title . '</h1></header>
                    ' . $content . '
                </section>
             </sidebar>';
        }
        return $leftSide;
    }

    public function footer() {
        $footer = '';
        $footer .= '<footer>
                <p> GLimPSE is Copyright &copy; Chris Rees 2012</p>
              </footer>';
        $footer .= '</body>
            </html>';

        return $footer;
    }

}

?>
