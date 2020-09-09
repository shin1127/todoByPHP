<?php
require_once("functions.php");

addTodo();
updateDone();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="hoge.css" />
    <title>PHP TODO</title>
  </head>
  <body>

  <h1>TODO by PHP</h1>
  <div class="addingTodo">
  <form action="index.php" method="post">
    <span>Task Name</span>
    <input type="text" name="name">
    <br>
    <span>Priority</span>

    <select name="priority">
    <option value="high">High</option>
    <option value="middle">Middle</option>
    <option value="low">Low</option>
    </select>
    <br>
    <button type="submit" name="submit">ADD</button>
    </form>



  </div>


    <div class="compare-box">
      <div class="compare-left-wrap">
        <div class="compare-left-head">Do</div>
        <div class="compare-left">
          <ul class="list">

          <?php showDo(); ?>

          </ul>
        </div>
      </div>
      <div class="compare-right-wrap">
        <div class="compare-right-head">Done</div>
        <div class="compare-right">
          <ul class="list">

          <?php showDone(); ?>

          </ul>
        </div>
      </div>
    </div>
</body>
</html>
