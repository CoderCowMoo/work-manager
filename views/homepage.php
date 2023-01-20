<?php 

// get all subject data from db
require 'controllers/subjects_doneness.php';


//header requires a heading variable
$heading = "Dashboard";
require 'partials/header.php';
require 'partials/nav.php';

$subjects = get_subjects_assoc(); 
?>
    <script>
        let subjects = ['ucat', 'english', 'software', 'methods', 'chemistry'];

        // this function handles the user checking and unchecking work they've done.
        // does this by finding element representing state and updating it.
        function tick_untick(subject) {
            let done_state = document.getElementById(subject.name);
            if (subject.checked) {
                done_state.classList.remove('red');
                done_state.classList.add('green');
                done_state.innerHTML = "✓";
            } else {
                done_state.classList.remove('green');
                done_state.classList.add('red');
                done_state.innerHTML = "✗";
            }
        }


        // this function handles the user clicking the submit button
        // it will send a POST request to the server with the subject states
        function add_to_db() {
            /* TODO refactor to use URL() class */
            // hostname just gives the domain/localhost
            let url = window.location.protocol + "//" + window.location.hostname + ':8082/updatedb'; // http://localhost:8082/updatedb
            let params = "";
            // parameters will be of form '{subject}={doneness}&...';
            subjects.forEach(subject => {
                // get doneness from elements UTF-8 tick
                let doneness = document.getElementById(subject).innerText == '✓' ? 1 : 0; // 1 if true, 0 if false
                params += subject + '=' + doneness + '&';
            });
            // remove last ampersand
            params = params.slice(0, -1);
            console.log(url + " and Data: " + params);
            let xhr = new XMLHttpRequest();
            // we'll make it async so that we can add a spinner in the button
            xhr.open('GET', url + "?" + params, true);
            xhr.send();
            /* TODO add spinner here and destroy it in onload function */
            console.log("Hello here");
            xhr.onload = () => {
                if (xhr.status != 400) {
                    // success
                    let success_element = document.createElement('p');
                    success_element.innerHTML = "Successfully updated database";
                    success_element.classList.add('alert');
                    success_element.classList.add('alert-success');
                    console.log(success_element);
                    document.getElementById('app-root').append(success_element);
                    // then set an async timeout to make it disappear TODO: Add fade
                    setTimeout(() => {
                        success_element.remove();
                    }, 2000);
                } else {
                    // failure
                    alert("Failed to update database");
                }
                console.log(xhr.responseText);
                console.log(xhr.status);
            }
        }
    </script>


    <div class="container" id="app-root">
        <div class="row">
            <?php echo "<p>Date: <b>" . $sql_date . "</b></p>"; ?>
            <table>
                <tr>
                    <th>Subject</th>
                    <th>Done [✓/✗]</th>
                </tr>
                <?php foreach($subjects as $subject=>$doneness): ?>
                    <tr>
                        <!-- UCAT must be fully cap, everything else ucfirst -->
                        <td><?php echo $subject == 'ucat' ? "UCAT" : ucfirst($subject) ?></td>
                        <td>
                            <?php $doneness ? print("<span id='$subject'class='green'>✓</span>") : print("<span id='$subject' class='red'>✗</span>"); ?>
                            <input type="checkbox" <?php $doneness ? print 'checked' : ''?> name="<?php echo $subject;?>" onclick="tick_untick(this)"/>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <input class="sub_button btn btn-primary" type="submit" value="Add to DB" name="submit" onclick="add_to_db()"/>
        </div>
<?php require 'partials/footer.php'; ?>