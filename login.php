<?php

/**
 * 
 *
 * @author cir8
 */
class login {

    public function __construct($content) {
        $this->head('GLimPSE :: Login');
        $this->body('Login', $content);
        $this->footer();
    }

    public function head($title) {
        echo '<!doctype html>
                <html>
                    <head>
                        <title>' . $title . '</title>
                        <link rel="stylesheet" href="html/styles.css">
                    </head> ';
    }

    public function navigation() {
        echo '<nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="search.php">Search</a></li>
                    <li><a class="selected" href="my_account.php">My Account</a></li>
                </ul>
             </nav>';
    }

    public function body($title, $content) {
        echo '<header>
                <h1>GLimPSE</h1>
              </header>';
        echo $this->navigation();
        echo $this->breadcrumbs();
        echo '<div id="contentWrapper">
                <section class="content">
                    <h1>' . $title . '</h1>       
                        ' . $content . '
                </section>';
        echo $this->sidebar('Login');
        echo'</div> ';
    }

    public function breadcrumbs() {
        echo '<div class="currentlocation">
                <p>My Account > Login</p>
              </div>';
    }
    
    public function sidebar($title) {
        echo '<sidebar>
                <section>
                    <header><h1>' . $title . '</h1></header>
                    <ul>
                        <li><a href="my_account.php">My Account</a></li>
                    </ul>
                </section>
             </sidebar>';
    }
    public function footer() {
        echo '<footer>
                <p> Copyright &copy; Chris Rees 2012</p>
              </footer>';
    }
}

?>
