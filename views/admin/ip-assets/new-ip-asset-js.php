<script>

$(document).ready(function() {
  // Listen for changes to the select fields
  $(document).on('change', 'input[name="author_id[]"]', function() {
    checkDuplicateAuthors(); // Call the comparison function
  });
});

 //Author ID table workaround.
 function showAuthorId(input) {
                var authorName = input.value;
                var authorId = "";
                var options = input.list.options;
                for (var i = 0; i < options.length; i++) {
                    var option = options[i];
                    if (option.value === authorName) {
                        authorId = option.text;
                        break;
                    }
                }
                $(input).closest('tr').find('.author-id-input').val(authorId);
            }

function checkDuplicateAuthors() {
  var authors = {};
  var duplicate = false;
  $('input[name="author_id[]"]').each(function() {
    var id = $(this).val().toLowerCase();
    if (id in authors) {
      duplicate = true;
      $(this).focus(); // Focus on the input field with duplicate value
      $('#error-msg').show(); // Show the error message
      return false; // Exit the loop if duplicate is found
    } else {
      authors[id] = true;
    }
  });
  if (!duplicate) {
    $('#error-msg').hide(); // Hide the error message if no duplicates found
  }
  return !duplicate; // Return false to prevent form submission if duplicate found
}


            var max =15; //max number of Authors
            var x =1; //represents the 1st author field
            var rowHtml = '<tr>\
                                    <td class="ipa-author-field">\
                                        <?php
                                        $query = "SELECT author_id, author_name FROM table_authors";
                                        $params = array();
                                        $result = pg_query_params($conn, $query, $params);
                                        echo '<input list="authors" name="author_name[]" style="width: 100%; height: 50px; padding: 10px 36px 10px 16px; border-radius: 5px; border: 1px solid var(--dark-grey);" placeholder="Author Name..." onchange="showAuthorId(this)">';
                                        echo '<datalist id="authors">';
                                        while ($row = pg_fetch_assoc($result)) {
                                            echo '<option value="' . $row['author_name'] . '">' . $row['author_id'] . '</option>';
                                        }
                                        echo '</datalist>';
                                        ?>
                                    </td>\
                                    <td class="ipa-author-field" style="text-align:center;"><button name="remove" style="height: 50px; width:3.7rem; border-radius: 5px; border: none; padding: 0 20px; background: var(--primary); color: var(--light); font-size: 25px; font-weight: 600; cursor: pointer; letter-spacing: 1px; font-weight: 600;"id="remove"><i class="fa-solid fa-xmark fa-xs"></i></button> </td>\
                                </tr>';
            $('.add-row-btn').click(function(){
                if (x < max) {
                $('#author-tbl-body').append(rowHtml);
                x++;
                    }

                //Remove row function
                $('#author-tbl').on('click','#remove',function(){
                    $(this).closest('tr').remove();
                    x--;
                });
            });

            //Auto Registration Number
            $(document).ready(function(){
                // Get the input fields
                const classOfWork = document.getElementById('class_of_work');
                var today = new Date();
                var year = today.getFullYear();

                // Get the registration number field
                const registrationNumber = document.getElementById('reg_num');

                // Listen for changes to the IPA registration radio buttons
                const ipaRegistration = document.getElementsByName('registerInfo');
                ipaRegistration.forEach(function (radio) {
                    radio.addEventListener('change', function () {
                        if (this.value === 'not-registered') {
                            // Generate the registration number
                            const classOW = classOfWork.value.split(' ').join('');
                            const yearNow = year.toString();
                            const registration = classOW + yearNow + '-';
                            
                            // Set the registration number field value
                            reg_num.value = registration;
                        } else {
                            // Clear the registration number field value
                            reg_num.value = '';
                        }
                    });
                });
            });
</script>