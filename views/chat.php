<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="./public/main.css" />
</head>
<body>
    
    <header class="chat-header">
        <h1>Chat OpenClassRooms</h1>
    </header>

    <main class="container">

        <section class="chat-form">
            <form action="chat_filter.php" method="post">

                <div class="form-error">
                    <?= $error ?>
                </div>

                <div class="form-group">
                    <label for="pseudo">
                        <span class="form-label">Pseudo :</span>
                        <input type="text" id="pseudo" name="pseudo" class="form-input" required value="<?= $pseudo ?>" />
                    </label>
                </div>

                <div class="form-group">
                    <label for="message">
                        <span class="form-label">Message :</span>
                        <textarea id="message" name="message" class="form-input" required  rows=5></textarea>
                    </label>
                </div>

                <div class="form-group">
                    <button class="form-btn" type="submit">Envoyer</button>
                </div>

            </form>
        </section>

        <section class="chat-room">

            <?php if($messages){ while($message = mysqli_fetch_array($messages)){ ?>
                <p class="chat-block">
                    <span class="chat-date"><?= $message['createdate'] ?></span>
                    <span class="chat-pseudo"><?= chat_decode( $message['pseudo'] ) ?></span>
                    <span class="chat-message"><?= chat_decode( $message['message'] ) ?></span>
                </p>
            <?php }} ?>

        </section>

    </main>

</body>
</html>