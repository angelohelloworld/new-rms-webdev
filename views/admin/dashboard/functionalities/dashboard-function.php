<?php
function getUserCount($conn, $reuse_stmt = false) {
    $query = "SELECT user_id FROM table_user;";
    if (!$reuse_stmt) {
        $stmt = pg_prepare($conn, "get_user_id", $query);
    }
    $result = pg_execute($conn, "get_user_id", array());
    if (!$result) {
        echo "Query failed: " . pg_last_error($conn);
    } else {
        $row_count = pg_num_rows($result);
        if ($row_count == 0) {
            return '0';
        } else {
            return $row_count;
        }
    }
}
function getAuthorCount($conn, $reuse_stmt = false) {
    $query = "SELECT author_id FROM table_authors;";
    if (!$reuse_stmt) {
        $stmt = pg_prepare($conn, "get_author_id", $query);
    }
    $result = pg_execute($conn, "get_author_id", array());
    if (!$result) {
        echo "Query failed: " . pg_last_error($conn);
    } else {
        $row_count = pg_num_rows($result);
        if ($row_count == 0) {
            return '0';
        } else {
            return $row_count;
        }
    }
}
function getArticleCount($conn, $reuse_stmt = false) {
    $query = "SELECT title_of_paper FROM table_publications;";
    if (!$reuse_stmt) {
        $stmt = pg_prepare($conn, "get_title_of_paper", $query);
    }
    $result = pg_execute($conn, "get_title_of_paper", array());
    if (!$result) {
        echo "Query failed: " . pg_last_error($conn);
    } else {
        $row_count = pg_num_rows($result);
        if ($row_count == 0) {
            return '0';
        } else {
            return $row_count;
        }
    }
}

function getContributors($conn) {
    $sql = "SELECT * FROM table_authors ORDER BY author_id ASC";
    $result = pg_query($conn, $sql);

    if(pg_num_rows($result) > 0){
        $contributors = array();
        while ($row = pg_fetch_assoc($result)) {
            $count1=0;
            $getAuthors = "SELECT authors FROM table_publications";
            $getAuthorsResult = pg_query($conn, $getAuthors);

            if(pg_num_rows($getAuthorsResult) > 0){
                while ($row2 = pg_fetch_assoc($getAuthorsResult)) {
                    $authorIds = explode(',', $row2['authors']);
                    foreach ($authorIds as $id) {
                        if ($id === $row['author_id'] ){
                            $count1=$count1+1;
                        }
                    }
                }
            }

            $count2=0;
            $getAuthors = "SELECT authors FROM table_ipassets";
            $getAuthorsResult = pg_query($conn, $getAuthors);

            if(pg_num_rows($getAuthorsResult) > 0){
                while ($row2 = pg_fetch_assoc($getAuthorsResult)) {
                    $authorIds = explode(',', $row2['authors']);
                    foreach ($authorIds as $id) {
                        if ($id === $row['author_id'] ){
                            $count2=$count2+1;
                        }
                    }
                }
            }

            $total_count = $count1 + $count2;
            if ($total_count > 0) {
                $contributors[] = array(
                    'author_name' => $row['author_name'],
                    'total_publications' => $total_count
                );
            }
        }

        // Sort contributors by number of publications in descending order
        usort($contributors, function($a, $b) {
            return $b['total_publications'] - $a['total_publications'];
        });

        // Display top 5 contributors
        $count = 0;
        ?>
        <table>
        <tr>
            <th>Authors</th>
            <th>Number of Publications</th>
        </tr>
        <?php
        foreach ($contributors as $contributor) {
            $count++;
            if ($count > 7) {
                break;
            }
            ?>
            <tr>
                <td><?=$contributor['author_name'];?></td>
                <td><?=$contributor['total_publications'];?></td>
            </tr>
            <?php
        }
    }
    ?>
    </table>
    <?php
}
function getMostViewedPapers($conn, $reuse_stmt = false) {
    $sql = "SELECT title_of_paper, number_of_citation FROM table_publications WHERE number_of_citation IS NOT NULL ORDER BY number_of_citation DESC LIMIT 3;";
    if (!$reuse_stmt) {
        $stmt = pg_prepare($conn, "get_most_viewed_papers", $sql);
    }
    $result = pg_execute($conn, "get_most_viewed_papers", array());

    $output = "<table>";
    $output .= "<tr><th>Title of Paper</th><th>Number of Citations</th></tr>";
    while ($row = pg_fetch_assoc($result)) {
        $output .= "<tr><td>".$row['title_of_paper']."</td><td>".$row['number_of_citation']."</td></tr>";
    }
    $output .= "</table>";

    return $output;
}
function getPublishedIPAssets($conn) {
    $query = "SELECT title_of_work FROM table_ipassets WHERE status = $1";
    $params = array("published");

    $query_run = pg_prepare($conn, "pub_query", $query);
    if(!$query_run) {
        echo "Prepared statement creation failed: " . pg_last_error($conn);
    } else {
        $result = pg_execute($conn, "pub_query", $params);
        if(!$result) {
            echo "Query execution failed: " . pg_last_error($conn);
        } else {
            $row_count = pg_num_rows($result);
            if($row_count == 0) {
                return '0';
            } else {
                return $row_count;
            }
        }
    }
}
function getProcessingIpAssets($conn, $reuse_stmt = false) {
    $query = "SELECT title_of_work FROM table_ipassets WHERE status = $1";
    $params = array("processing");

    if (!$reuse_stmt) {
        $stmt = pg_prepare($conn, "proc_query", $query);
    }

    $result = pg_execute($conn, "proc_query", $params);

    if (!$result) {
        return "Query execution failed: " . pg_last_error($conn);
    } else {
        $row_count = pg_num_rows($result);
        if ($row_count == 0) {
            return '0';
        } else {
            return $row_count;
        }
    }
}

?>