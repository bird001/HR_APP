

<?php
$sql_view = "select * from DashBoard order by Time desc";
$view_arr = array();
$view_arr = $conn->query($sql_view);
?>

<div class="newstape">
    <div class="newstape-content">
        <?php
        while ($row = $view_arr->fetch_assoc()) {
            $headline = $row['Headline'];
            $story = $row['Story'];
            $time = $row['Time'];
            ?>

            <div class = "news-block">
                <h2><?php echo $headline ?></h2>
                <small><?php ?></small>
                <p class = "text-justify"> <?php echo $story ?></p>
                <hr />
            </div>

            <?php
        }
        ?>
    </div>
</div>


<?php include("../Templates/footer_dashboard.php"); ?>