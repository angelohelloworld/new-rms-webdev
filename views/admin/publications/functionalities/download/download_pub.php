
<?php 
    include '../../../../../db/db.php';
?>
<link rel="stylesheet" href="../../../../../css/index.css">
<link rel="stylesheet" href="../../functionalities/download/download_pub.css">

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- download as excel -->
<script src="https://unpkg.com/xlsx@0.15.6/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<body>
<?php    
    $search = (isset($_GET['search']) && strpos($_GET['search'], "'") === false )? $_GET['search']: 'empty_search';
?>
    <main  id="dl-modal-container">
    <section>
        <div class="header">
                <div class="dl-buttons">
                <button onclick="downloadExcelFile()" class="btn"><i class="fas fa-file-excel fa-lg" style="color: green"></i></button>
            </div>
            <div class="left">
                <form action='' method='get'>
                    <div class="form-group">
                        <input type='text' name='search' value='<?php $search_query?>' placeholder="Search..." >
                        <i class='bx bx-search icon' ></i>
                    </div>
                </form>
            </div>
        </div>
          <!-- <div class="table-container"> -->
                <?php
                    include_once '../download/publication_table_download.php';
                ?>
            <!-- </div> -->
        </section>
    </main>
</section>
<link rel="stylesheet" href="sweetalert2.min.css">
<script src="../download/download_pub.js"></script>
</body>
