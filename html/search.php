<!doctype html>
<html>
    <head>
        <title>GLimPSE :: Search</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header>
            <h1>GLimPSE</h1>
        </header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li class="selected"><a href="#">Search</a></li>
                <li><a href="#">My Account</a></li>
                <li><a href="#">Soemthing</a></li>
            </ul>
        </nav>
        <div class="currentlocation">

        </div>
        <div id="contentWrapper">
            <section class="content">
                <form method="post" action="testecho2.php">
                    <div class="search">
                        <input type="text" size="60" maxlength="255" required="true" autofocus="true" placeholder="I'm looking for..." title="Enter your keywords and click the search button" name="searchquery" /></label> 
                        <input type="submit" value="Search" /><br/>
                        <div class="clear"></div>
                    </div>
                </form>
            </section>
            <sidebar>
                <h1>Search</h1>
                <ul>
                    <li><a href="search.html">Search</a></li>
                    <li><a href="advsearch.html">Advanced Search</a></li>
                    <li><a href="searchpref.html">Search Preferences</a></li>
                </ul>
            </sidebar>
        </div>
        <footer>
            <p> Copyright &copy; Chris Rees 2012 </p><br/>
        </footer>

    </body>
</html>