<?php
// getting the total number of users account
function getUserCount($userurl) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $userurl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Failed to retrieve data from the endpoint.";
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if ($data === null) {
        echo "Failed to parse JSON response.";
        return false;
    }

    $userCount = count($data['table_user']);

    return $userCount;
}


// getting the total number of authors 
function getAuthorCount($authorurl) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $authorurl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Failed to retrieve data from the endpoint.";
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if ($data === null) {
        echo "Failed to parse JSON response.";
        return false;
    }

    $authorCount = count($data['table_authors']);

    return $authorCount;
}

// getting the total number of articles in publications
function getArticleCount($publicationurl) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $publicationurl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Failed to retrieve data from the endpoint.";
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if ($data === null) {
        echo "Failed to parse JSON response.";
        return false;
    }

    $articleCount = count($data['table_publications']);

    return $articleCount;
}


// getting the number of authors with most contributions in publications

function getPublicationsContributors($authorurl, $publicationurl) {

    $responsePublications = file_get_contents($publicationurl);

    $dataPublications = json_decode($responsePublications, true);

    $authorsColumn = array_column($dataPublications['table_publications'], 'authors');

    $authorCounts = array();

    foreach ($authorsColumn as $authors) {
        $authorIds = explode(',', $authors);

        foreach ($authorIds as $authorId) {
            $authorId = trim($authorId); // Remove leading/trailing whitespaces
            if (!empty($authorId)) {
                if (isset($authorCounts[$authorId])) {
                    $authorCounts[$authorId]++;
                } else {
                    $authorCounts[$authorId] = 1;
                }
            }
        }
    }

    arsort($authorCounts);

    $top9Authors = array_slice($authorCounts, 0, 9, true);

    $responseAuthors = file_get_contents($authorurl);

    $dataAuthors = json_decode($responseAuthors, true);

    $authorIdColumn = array_column($dataAuthors['table_authors'], 'author_id');
    $authorNameColumn = array_column($dataAuthors['table_authors'], 'author_name');

    $authorMapping = array_combine($authorIdColumn, $authorNameColumn);

    $contributors = array();

    foreach ($top9Authors as $authorId => $count) {
        if (isset($authorMapping[$authorId])) {
            $authorName = $authorMapping[$authorId];
            $contributors[] = array(
                'author_name' => $authorName,
                'total_publications' => $count
            );
        }
    }

    usort($contributors, function($a, $b) {
        return $b['total_publications'] - $a['total_publications'];
    });

    $count = 0;
    ?>
    <table>
        <tr>
            <th>Authors</th>
            <th>Number of Publications</th>
        </tr>
        <?php foreach ($contributors as $contributor) {
            $count++;
            if ($count > 9) {
                break;
            }
        ?>
            <tr>
                <td><?= $contributor['author_name']; ?></td>
                <td><?= $contributor['total_publications']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php
}

// getting the number of authors with most contributions in ip assets


function getIpAssetsContributors($ipassetsurl, $authorurl) {
    $responseIpAssets = file_get_contents($ipassetsurl);

    $dataIpAssets = json_decode($responseIpAssets, true);

    $authorsColumn = array_column($dataIpAssets['table_ipassets'], 'authors');

    $authorCounts = array();

    foreach ($authorsColumn as $authors) {
        $authorIds = explode(',', $authors);

        foreach ($authorIds as $authorId) {
            $authorId = trim($authorId); // Remove leading/trailing whitespaces
            if (!empty($authorId)) {
                if (isset($authorCounts[$authorId])) {
                    $authorCounts[$authorId]++;
                } else {
                    $authorCounts[$authorId] = 1;
                }
            }
        }
    }

    arsort($authorCounts);

    $top9Authors = array_slice($authorCounts, 0, 9, true);

    $responseAuthors = file_get_contents($authorurl);

    $dataAuthors = json_decode($responseAuthors, true);

    $authorIdColumn = array_column($dataAuthors['table_authors'], 'author_id');
    $authorNameColumn = array_column($dataAuthors['table_authors'], 'author_name');

    $authorMapping = array_combine($authorIdColumn, $authorNameColumn);

    $contributors = array();

    foreach ($top9Authors as $authorId => $count) {
        if (isset($authorMapping[$authorId])) {
            $authorName = $authorMapping[$authorId];
            $contributors[] = array(
                'author_name' => $authorName,
                'total_publications' => $count
            );
        }
    }

    usort($contributors, function($a, $b) {
        return $b['total_publications'] - $a['total_publications'];
    });

    $count = 0;
    ?>
    <table>
        <tr>
            <th>Authors</th>
            <th>Number of Publications</th>
        </tr>
        <?php foreach ($contributors as $contributor) {
            $count++;
            if ($count > 9) {
                break;
            }
        ?>
            <tr>
                <td><?= $contributor['author_name']; ?></td>
                <td><?= $contributor['total_publications']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php
}

// getting the most cited articles in publications

function getMostViewedPapers($publicationurl) {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $publicationurl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if ($response === false) {
        $error = curl_error($curl);
        return "cURL Error: " . $error;
    }

    curl_close($curl);
    
    $data = json_decode($response, true);

    $citationData = array_column($data['table_publications'], 'number_of_citation', 'title_of_paper');

    arsort($citationData); // Sort the citations in descending order

    $topCitations = array_slice($citationData, 0, 4, true); // Preserve the keys in the resulting array

    $output = "<table>";
    $output .= "<tr><th>Title of Paper</th><th>Number of Citations</th></tr>";

    foreach ($topCitations as $title => $citation) {
        $output .= "<tr><td>" . $title . "</td><td>" . $citation . "</td></tr>";
    }

    $output .= "</table>";

    echo $output;
}

// getting the number of published articles
function getPublishedIPAssets($ipassetsurl) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $ipassetsurl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Failed to retrieve data from the endpoint.";
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if ($data === null) {
        echo "Failed to parse JSON response.";
        return false;
    }

    $publishedIPAssetCount = count($data['table_ipassets']);

    return $publishedIPAssetCount;
}

// getting the recently added articles

function getRecentIpAssets($ipassetsurl) {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $ipassetsurl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);

    if ($response === false) {
        $error = curl_error($curl);
        return "cURL Error: " . $error;
    }

    curl_close($curl);

    $data = json_decode($response, true);

    $dateData = array_column($data['table_ipassets'], 'date_registered', 'title_of_work');

    arsort($dateData);

    $recentArticles = array_slice($dateData, 0, 4);

    $output = "<table>";
    $output .= "<tr><th>Title</th><th>Date Published</th></tr>";

    foreach ($recentArticles as $workTitle => $publisheddate) {
        $formattedDate = date('F d, Y', strtotime($publisheddate));
        $output .= "<tr><td>" . $workTitle . "</td><td>" . $formattedDate . "</td></tr>";
    }

    $output .= "</table>";

    echo $output;

}


// getting the ip assets per campus

function getIpAssetsCampus($ipassetsurl) {
    $datacampus = file_get_contents($ipassetsurl);
    $dataIpAssets = json_decode($datacampus, true);
    $campusColumn = array_column($dataIpAssets['table_ipassets'], 'campus');

    $PBcount = 0;
    $Alcount = 0;
    $Nacount = 0;

    foreach ($campusColumn as $campus) {
        if ($campus === 'Pablo Borbon') {
            $PBcount++;
        } elseif ($campus === 'Alangilan') {
            $Alcount++;
        } elseif ($campus === 'Nasugbu') {
            $Nacount++;
        }
    }

    $data = array($PBcount, $Alcount, $Nacount);
    $labels = array('Pablo Borbon', 'Alangilan', 'Nasugbu');

    return array(
        "data" => json_encode($data),
        "labels" => json_encode($labels)
    );
}



// getting the type of publication in table publication
function getPublicationType($publicationurl){

    $datatype = file_get_contents($publicationurl);
    $dataPublication = json_decode($datatype, true);
    $typesColumn = array_column($dataPublication['table_publications'], 'type_of_publication');

    $Intcount = 0;
    $Nacount = 0;

    foreach ($typesColumn as $type) {
        if ($type === 'International') {
            $Intcount++;
        } elseif ($type === 'National') {
            $Nacount++;
        }
    }

    $data = array($Nacount, $Intcount);
    $labels = array('National', 'International');

    return array(
        "data" => json_encode($data),
        "labels" => json_encode($labels)
    );
}
// getting the number ip assets per year
function getIPAssetsPerYear($ipassetsurl) {

    $dataIpassets = file_get_contents($ipassetsurl);
    $datadate = json_decode($dataIpassets, true);
    $datesColumn = array_column($datadate['table_ipassets'], 'date_registered');

    foreach ($datesColumn as $date) {
        $yearValue = date("Y", strtotime($date)); // Extract year (yyyy) from date
        if (isset($year[$yearValue])) {
            $year[$yearValue]++;
        } else {
            $year[$yearValue] = 1;
        }
    }

    ksort($year);
    
    $data = array_values($year); // Values are the ipassets counts
    $labels = array_keys($year); // Keys are the years

    return array(
        "data" => json_encode($data),
        "labels" => json_encode($labels)
    );
}


// getting the number of publicatons per year 


function getPublicationsPerYear($publicationurl) {
    $dataPublication = file_get_contents($publicationurl);
    $datadate = json_decode($dataPublication, true);
    $datesColumn = array_column($datadate['table_publications'], 'date_published');

    foreach ($datesColumn as $date) {
        $yearValue = date("Y", strtotime($date)); // Extract year (yyyy) from date
        if (isset($year[$yearValue])) {
            $year[$yearValue]++;
        } else {
            $year[$yearValue] = 1;
        }
    }

    ksort($year);

    $data = array_values($year); // Values are the publication counts
    $labels = array_keys($year); // Keys are the years

    return array(
        "data" => json_encode($data),
        "labels" => json_encode($labels)
    );
}


?>