<?php 
session_start();
require_once 'vendor/autoload.php';
require_once 'head/Head.php';

?>


<body>

    <?php echo 'Welcome, ' . $_SESSION['naam'] . '!'; ?>
    <?php
    if (isset($_SESSION['inloggen']) && $_SESSION['inloggen']) {
        echo '<a href="Login.php">Logout</a>';
    }
    ?>
    <div class="welkom">
        <h1>Welkom !</h1>

        <p>Over ons:
            .</p>

    </div>


</body>
<main>
    <section>
        <article class="info">

        </article>
    </section>

</main>