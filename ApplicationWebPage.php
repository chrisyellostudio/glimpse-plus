<?php

/**
 * Description of ApplicationWebPage
 *
 * @author cir8
 */
include 'ApplicationFunctions.php';
include 'AccountFunctions.php';

define('APPLICATION_HEADER', 'GLimPSE');
define("APPLICATION_TITLE", APPLICATION_HEADER . " :: ");
define("DEFAULT_STYLE", 'styles.css');

class ApplicationWebPage {

    public function head($title, $styleArray = array(), $scriptArray = array()) {
        $title = APPLICATION_TITLE . $title;
        $head = '';
        $head .= '<!doctype html>
                <html>
                    <head>
                        <title>' . $title . '</title>
                        <link rel="stylesheet" href="html/' . DEFAULT_STYLE . '">';
        if (sizeof($styleArray) > 1) {
            foreach ($styleArray as $style) {
                $head .= '<link rel="stylesheet" href="html/' . $stlye . '">';
            }
        }
        if (sizeof($scriptArray) >= 1) {
            foreach ($scriptArray as $script) {
                $head .= '<script type="text/javascript" src="' . $script . '"></script>';
            }
        }
        $head .= '</head> ';

        return $head;
    }

    public function navigation($currentBranch) {
        $home = $about = $search = $acc = $nav = '';

        if ($currentBranch == "home") {
            $home = ' class="selected"';
        } elseif ($currentBranch == "about") {
            $about = ' class="selected"';
        } elseif ($currentBranch == "search") {
            $search = ' class="selected"';
        } elseif ($currentBranch == "account") {
            $acc = ' class="selected"';
        }

        $nav .= '<nav>
                <ul>
                    <li' . $home . '><a href="home.php">Home</a></li>
                    <li' . $about . '><a href="about.php">About</a></li>
                    <li' . $search . '><a href="search.php">Search</a></li>
                    <li' . $acc . '><a href="account.php">My Account</a></li>
                </ul>
             </nav>';

        return $nav;
    }

    public function breadcrumbs($breadArray) {
        $breadcrumbs = '';
        $breadcrumbs .= '<div class="currentlocation">';
        $breadcrumbs .= '<p>';
        foreach ($breadArray as $link => $value) {
            if ($link == 0) {
                $breadcrumbs .= '<a href="' . $link . '">' . $value . '</a> / ';
            } elseif ($link == 1) {
                $breadcrumbs .= '<a class="red" href="' . $link . '">' . $value . '</a>';
            }
        }
        $breadcrumbs .= '</p>';
        $breadcrumbs .= '</div>';

        return $breadcrumbs;
    }

    public function body(ApplicationWebBody $bodyObject) {
        $body = '';
        if (is_object($bodyObject)) {
            $body .= '<header class=title>
                <h1>' . APPLICATION_HEADER . '</h1>' .
                    AccountFunctions::displayUser() . ' </header>';
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
        }
        return $body;
    }

    /**
     * Creates the right hand side bar on the web page.
     * 
     * @param string $title [optional] The title of the right side bar.
     * @param array $contentLinks
     * @return string Returns a string containing the html for the sidebar
     */
    public function rightSidebar($title = '', $contentLinks ='') {
        $rightSide = '';
        if ($title || $contentLinks != '') {
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
        }
        return $rightSide;
    }

    public function leftSidebar($title, $content) {
        $leftSide = '';
        if ($title || $content != '') {
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
            <hr>
                <p> GLimPSE &copy; Chris Rees 2012</p>
              </footer>';
        $footer .= '</body>
            </html>';

        return $footer;
    }

}

?>
