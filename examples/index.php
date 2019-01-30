<?php
include('Db.php');
$mysqli = new Db();
$conn = $mysqli->db();


$sql = "SELECT *  FROM posts";
$query = $conn->query($sql);
$row = $query->num_rows;

$page_rows = 3;

$last = ceil($row / $page_rows);

if ($last < 1) {
    $last = 1;
}

$page_num = 1;

if (isset($_GET['pn'])) {
    $page_num = preg_replace('#[^0-9]#', '', $_GET['pn']);
}

if ($page_num < 1) {
    $page_num = 1;
} else if ($page_num > $last) {
    $page_num = $last;
}

$limit = 'LIMIT ' . ($page_num - 1) * $page_rows . ',' . $page_rows;

$sql = "SELECT * FROM posts ORDER BY id DESC $limit";
$query = $conn->query($sql);


$page_out_of = "Page <b>$page_num</b> of <b>$last</b>";

$paginationCtrls = '';

if ($last != 1) {

    if ($page_num > 1) {
        $previous = $page_num - 1;
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '">Previous</a> &nbsp; &nbsp; ';

        for ($i = $page_num - 4; $i < $page_num; $i++) {
            if ($i > 0) {
                $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '">' . $i . '</a> &nbsp; ';
            }
        }
    }

    $paginationCtrls .= '' . $page_num . ' &nbsp; ';

    for ($i = $page_num + 1; $i <= $last; $i++) {
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '">' . $i . '</a> &nbsp; ';
        if ($i >= $page_num + 4) {
            break;
        }
    }

    if ($page_num != $last) {
        $next = $page_num + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $next . '">Next</a> ';
    }
}
$post_list = '';


while ($row = $query->fetch_assoc()) {

    $id = $row["id"];
    $title = $row["title"];
    $desciption = $row["description"];

    $post_list .= '<p><a href="single.php?id=' . $id . '"><h3>' . $title . '</h3> <p>' . $desciption . '</p></a><br></p>';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Custom Pagination</title>
    </head>
    <body>
        <div>
            <p><?php echo $page_out_of; ?></p>
            <p><?php echo $post_list; ?></p>
            <div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
        </div>
    </body>
</html>

