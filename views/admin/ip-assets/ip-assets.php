<title>RMS | IP ASSETS</title>
<?php 
    include '../../../includes/admin/templates/header.php';
?>
<link rel="stylesheet" href="../../../css/index.css">
<link rel="stylesheet" href="./ip-assets.css">
<style>
    /*style for download modal */
  

   /*style for download modal */
   .modal-content1 {
    background-color: #fff;
    margin: 5% auto;
    margin-left: 30%;
    padding: 30px;
    padding-top: 80px;
    width: 60%;
    height: 75%;
    text-align: center;
    border-radius: 20px;
    position: relative;
    opacity: 2;
}

.modal-content1 iframe {
    width: 100%;
    height: calc(100% - 5px); /* Subtract height of close button */
    /* border: 2px solid black; */
}


    .close {
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            z-index: 9999;
            pointer-events: auto !important;
            color: black;
            height: 30px;
        }
</style>
<body>
    <?php
        include '../../../includes/admin/templates/navbar.php';
    ?>

    <main>
        <div class="header">
            <h1 class="title">IP-assets</h1>
            <div class="left">
                <form action="#">
                    <div class="form-group">
                        <input type="text" placeholder="Search...">
                        <i class='bx bx-search icon' ></i>
                    </div>
                </form>
                <a href="./new-ip-asset.php" class="addBtn"><i class='bx bxs-file-plus icon' ></i>New Article</a>
            </div>
        </div>
        <section>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Registration Number</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Class of Work</th>
                            <th>Date Registered</th>
                            <th>Campus</th>
                            <th>College</th>
                            <th>Programs</th>
                            <th>Authors</th>
                            <th class='stickey-col-header'  style="background-color: var(--grey);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td style="min-width: 320px;">The Design and Development of A's Glass and Aluminum Online Booking System</td>
                            <td>Type</td>
                            <td>ClassOfWork</td>
                            <td>January 1, 2023</td>
                            <td>Campus</td>
                            <td>College</td>
                            <td>Programs</td>
                            <td>Authors</td>
                            <td class='pb-action-btns stickey-col'>
                                <a href="#" class="edit-btn">Edit</a>
                                <a href="#" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <p>Article Count : 1</p>
                <div class="download">
                    <button class="download-btn">Download</button>
                </div>
                <div class="pagination">
                    <li>
                        <a href="#"><i class='bx bx-chevrons-left icon' ></i></a>
                    </li>
                    <li>
                        <a href="#"><i class='bx bx-chevron-left icon' ></i></a>
                    </li>
                    <li>
                        <span class="current-page">1</span>
                    </li>
                    <li>
                        <a href="#"><i class='bx bx-chevron-right icon' ></i></a>
                    </li>
                    <li>
                        <a href="#"><i class='bx bx-chevrons-right icon' ></i></a>
                    </li>
                </div>
            </div>
    </main>
    </section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>
<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
<script src="./ip-assets.js"></script>
</body>

<?php
    include '../../../includes/admin/templates/footer.php';
?>