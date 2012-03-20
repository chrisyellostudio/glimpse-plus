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

    public function __construct() {
        $this->head($title, $styleArray, $script);
        $this->body($navbranch, $breadArray);
        $this->footer();
    }

    public function head($title, $styleArray, $script) {
        $title = APPLICATION_TITLE . $title;
        $head = '';
        $head .= '<!doctype html>
                <html>
                    <head>
                        <title>' . $title . '</title>
                        <link rel="stylesheet" href="html/' . DEFAULT_STYLE . '">';
        if (sizeof($styleArray)) {
            foreach ($styleArray as $style) {
                $head .= '<link rel="stylesheet" href="html/' . $stlye . '">';
            }
        }
        if (isset($script)) {
            $head .= '<script type="text/javascript">' . $script . '</script>';
        }
        $head .= '</head> ';

        return $head;
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
        
        return $nav;
    }

    public function breadcrumbs($breadArray) {
        $breadcrumbs = '';
        $breadcrumbs .= '<div class="currentlocation">';
        $breadcrumbs .= '<p>' . implode(' > ', $breadArray) . '</p>';
        $breadcrumbs .= '</div>';

        return $breadcrumbs;
    }

    public function body($currentBranch, $breadArray, $bodytitle, $bodycontent, $righttitle, $rightcontentlinks) {
        $body = '';
        $body .= '<header>
                <h1>' . APPLICATION_HEADER . '</h1>
              </header>';
        echo $this->navigation($currentBranch);
        echo $this->breadcrumbs($breadArray);
        echo '<div id="contentWrapper">';
        echo $this->leftSidebar($title, $contentLinks);
        echo '<section class="content">
                    <h1>' . $title . '</h1>       
                        ' . $content . '
                </section>';
        echo $this->rightSidebar($title, $contentLinks);
        echo'</div> ';
    }

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
        $leftSide .= '<sidebar>
                <section>
                    <header><h1>' . $title . '</h1></header>
                    ' . $content . '
                </section>
             </sidebar>';

        return $leftSide;
    }

    public function footer() {
        $footer = '';
        $footer .= '<footer>
                <p> GLimPSE is Copyright &copy; Chris Rees 2012</p>
              </footer>';

        return $footer;
    }

}

?>
