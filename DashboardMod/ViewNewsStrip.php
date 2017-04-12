<?php
$sql_view = "select * from DashBoard order by Time desc limit 10";//select the latest news
$view_arr = array();
$view_arr = $conn->query($sql_view);
?>
<div class="newsticker">
    <ul class="newsticker-list">
        <?php
        while ($row = $view_arr->fetch_assoc()) {
            $headline = $row['Headline'];
            $story = $row['Story'];
            $time = $row['Time'];
            ?>

            <li class="newsticker-item">
                <?php
                echo $story; //display news
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
</div>