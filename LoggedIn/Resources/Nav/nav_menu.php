<nav>
        <div id="logo">Your Logo here</div>

        <label for="drop" class="toggle">Menu</label>
        <input type="checkbox" id="drop" />
            <ul class="menu">
                <li <?php if($_SERVER['SCRIPT_NAME']=="/TestingArea51/LoggedIn/index.php") { ?>  class="active"   <?php   }  ?>><a href="#">Home</a></li>
                <li>
                    <!-- First Tier Drop Down -->
                    <label for="drop-1" class="toggle">WordPress +</label>
                    <a href="#">WordPress</a>
                    <input type="checkbox" id="drop-1"/>
                    <ul class="drop_1">
                        <li><a href="#">Themes and stuff</a></li>
                        <li><a href="#">Plugins</a></li>
                        <li><a href="#">Tutorials</a></li>
                    </ul> 
                </li>
                <li>

                <!-- First Tier Drop Down -->
                <label for="drop-2" class="toggle">Web Design +</label>
                <a href="#">Web Design</a>
                <input type="checkbox" id="drop-2"/>
                <ul>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Links</a></li>
                </ul>
                </li>
                <li><a href="#">Graphic Design</a></li>
                <li><a href="#">Inspiration</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </nav>