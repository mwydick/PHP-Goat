<?php declare(strict_types=1);

echo "Starting...\n";

@unlink("./data/db.sqlite3");

$db = new \SQLite3("./data/db.sqlite3");

$db->exec("
    CREATE TABLE IF NOT EXISTS users (
        username text NOT NULL PRIMARY KEY,
        password text
    )
");

$db->exec("
    CREATE TABLE IF NOT EXISTS notes (
        note_id integer NOT NULL PRIMARY KEY,
        username text,
        title text,
        body text,
        is_public int
    )
");

$db->exec("
    INSERT INTO users (username, password)
    VALUES
        ('admin', 'donteventhinkaboutit'),
        ('meow', 'kittycatkittycat'),
        ('user', 'whoami')
");

$db->exec("
    INSERT INTO notes (username, title, body, is_public)
    VALUES
        ('admin', 'Welcome to NotesIO', 'Hope you like it here! Go ahead and <a href=\"/register\">register to make your own notes.', 1),
        ('admin', 'Journal Entry 1', 'I sure hope this takes off.', 0),
        ('meow', 'Nunc a ullamcorper...', 'Nunc a ullamcorper urna. Quisque gravida dolor erat, id commodo tortor posuere ut. Proin elit elit, elementum nec volutpat sit amet, pellentesque in tortor. Vivamus ut nisl auctor, feugiat quam ut, faucibus arcu. Nullam sit amet elit quis ante efficitur consequat egestas vitae urna. Vestibulum fermentum maximus purus, ut ornare quam iaculis eu. Suspendisse vitae fringilla sapien, eget accumsan enim. Donec convallis, justo vel venenatis sollicitudin, quam lorem sodales nulla, eget pulvinar tellus diam tempor nunc. Duis porta, arcu finibus tincidunt vestibulum, erat dolor dictum lorem, a porttitor purus libero sit amet lacus. Donec vestibulum erat aliquam aliquam finibus. Fusce at ante magna. Suspendisse potenti. Curabitur pellentesque blandit arcu ullamcorper eleifend. Nulla facilisi. Maecenas nec nunc non odio pharetra tristique.', 1),
        ('meow', 'Pellentesque habitant morbi...', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque blandit lorem metus. Nullam ac consectetur ante. Fusce maximus iaculis eleifend. Vestibulum sit amet massa quis magna sodales vulputate a vel lorem. Nulla iaculis lacus ut magna efficitur, quis porttitor turpis dapibus. Ut ut vulputate mi. Nunc ex diam, ornare ut imperdiet nec, convallis non quam. Nullam lobortis varius mi id bibendum. Donec eget orci porttitor, vehicula sapien et, suscipit est. Nullam vel condimentum felis, ut facilisis risus. Nam malesuada augue eu felis rhoncus, ac viverra velit varius. Suspendisse eget augue dignissim, ullamcorper lorem vel, blandit orci. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 1),
        ('user', 'PRIVATE JOURNAL Day 1', 'Aliquam erat volutpat. Vivamus sodales ut mi ac varius. Nullam aliquet lacinia libero, in auctor tortor sollicitudin mattis. Morbi ac elit non sem porttitor condimentum eu sed enim. Cras egestas, magna eget commodo tincidunt, velit enim condimentum velit, non pretium ligula velit sit amet tellus. Suspendisse sed libero eu arcu accumsan tincidunt sed sit amet massa. Sed neque neque, malesuada id sapien in, dignissim pellentesque dui. Quisque et semper massa. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce ac elit ut sem aliquet finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris ornare dui et magna hendrerit tristique. Integer eros odio, mattis in dolor nec, iaculis fringilla ante. Integer ante metus, viverra ac suscipit at, rutrum ut nibh. Vivamus non urna sem.', 0)
 ");

echo "Finished.\n";
