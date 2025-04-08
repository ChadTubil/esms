<?= $this->extend("layouts/base"); ?>

<?= $this->section("title"); ?>
    <?= $page_title; ?>
<?= $this->endSection(); ?>
<?= $this->section("page_heading"); ?>
    <?= $page_heading; ?>
<?= $this->endSection(); ?>
<?= $this->section("page_p"); ?>
    <?= $page_p; ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
    <!-- ----------- SIDEBAR ------------------ -->
    <?= $this->include("partials/sidebar"); ?>  
    <!-- ----------- END OF SIDEBAR ------------------ --> 

    <!-- Begin Page Content -->
    <?php foreach($farstudent as $fars): ?>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>EVALUATION FOR: <strong><?= $fars['farname']; ?></strong></h3>
                            <br>
                            <h4><strong>I. TEACHING PERFORMANCE</strong></h4>
                            <h5><strong>RATE THE TEACHER USING THE SCALE BELOW</strong><br>
                                5 - EXCELLENT <br>
                                4 - VERY SATISFACTORY <br>
                                3 - SATISFACTORY <br>
                                2 - BELOW SATISFACTORY <br>
                                1 - POOR <br>
                                SKIP or LEAVE IT IF NOT APPLICABLE</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <?= form_open('studentfar/evaluationthird/'.$fars['farid']); ?>
                            <div class="card-body">
                                <h5>A. TEACHING COMPETENCE/ USE OF INSTRUCTIONAL AIDS</h5>
                                <br>
                                <!-- 1 -->
                                <h5>1. Presented instructions and objectives of the course/subject to the class at the start of the semester.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq1" id="FARQ1" value="1" <?php if($fars['farq1'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq1" id="FARQ11" value="2" <?php if($fars['farq1'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq1" id="FARQ111" value="3" <?php if($fars['farq1'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq1" id="FARQ1111" value="4" <?php if($fars['farq1'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq1" id="FARQ11111" value="5" <?php if($fars['farq1'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 2 -->
                                <h5>2. Presented and discussed the subject matter with mastery (minimal dependency on notes, and/or presentations).</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq2" id="FARQ2" value="1" <?php if($fars['farq2'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq2" id="FARQ22" value="2" <?php if($fars['farq2'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq2" id="FARQ222" value="3" <?php if($fars['farq2'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq2" id="FARQ2222" value="4" <?php if($fars['farq2'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq2" id="FARQ22222" value="5" <?php if($fars['farq2'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 3 -->
                                <h5>3. Added to the body of knowledge and information presented during discussions or interactions with students.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq3" id="FARQ3" value="1" <?php if($fars['farq3'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq3" id="FARQ33" value="2" <?php if($fars['farq3'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq3" id="FARQ333" value="3" <?php if($fars['farq3'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq3" id="FARQ3333" value="4" <?php if($fars['farq3'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq3" id="FARQ33333" value="5" <?php if($fars['farq3'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 4 -->
                                <h5>4. Used technology/ course tools for discussions and presentations.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq4" id="FARQ4" value="1" <?php if($fars['farq4'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq4" id="FARQ44" value="2" <?php if($fars['farq4'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq4" id="FARQ444" value="3" <?php if($fars['farq4'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq4" id="FARQ4444" value="4" <?php if($fars['farq4'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq4" id="FARQ44444" value="5" <?php if($fars['farq4'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 5 -->
                                <h5>5. Established clear guidelines for the students that include learner and instructor responsibilities, communication/ etiquette, and techniques to support the learner.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq5" id="FARQ5" value="1" <?php if($fars['farq5'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq5" id="FARQ55" value="2" <?php if($fars['farq5'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq5" id="FARQ555" value="3" <?php if($fars['farq5'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq5" id="FARQ5555" value="4" <?php if($fars['farq5'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq5" id="FARQ55555" value="5" <?php if($fars['farq5'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 6 -->
                                <h5>6. Required assignments, activities, readings, and/or projects which are appropriate and reasonable.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq6" id="FARQ6" value="1" <?php if($fars['farq6'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq6" id="FARQ66" value="2" <?php if($fars['farq6'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq6" id="FARQ666" value="3" <?php if($fars['farq6'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq6" id="FARQ6666" value="4" <?php if($fars['farq6'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq6" id="FARQ66666" value="5" <?php if($fars['farq6'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 7 -->
                                <h5>7. Learning materials and lessons emphasized logical, analytical, critical, and creative skills.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq7" id="FARQ7" value="1" <?php if($fars['farq7'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq7" id="FARQ77" value="2" <?php if($fars['farq7'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq7" id="FARQ777" value="3" <?php if($fars['farq7'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq7" id="FARQ7777" value="4" <?php if($fars['farq7'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq7" id="FARQ77777" value="5" <?php if($fars['farq7'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 8 -->
                                <h5>8. Used multimedia (photos, images, videos, audio, etc.) which are within the coverage of the lesson. </h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq8" id="FARQ8" value="1" <?php if($fars['farq8'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq8" id="FARQ88" value="2" <?php if($fars['farq8'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq8" id="FARQ888" value="3" <?php if($fars['farq8'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq8" id="FARQ8888" value="4" <?php if($fars['farq8'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq8" id="FARQ88888" value="5" <?php if($fars['farq8'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 9 -->
                                <h5>9. Followed principles of grammar and sentence structure within the modules/lessons. </h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq9" id="FARQ9" value="1" <?php if($fars['farq9'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq9" id="FARQ99" value="2" <?php if($fars['farq9'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq9" id="FARQ999" value="3" <?php if($fars['farq9'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq9" id="FARQ9999" value="4" <?php if($fars['farq9'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq9" id="FARQ99999" value="5" <?php if($fars['farq9'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 10 -->
                                <h5>10. Communicated ideas fluently with appropriate medium of instruction. </h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq10" id="FARQ10" value="1" <?php if($fars['farq10'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq10" id="FARQ100" value="2" <?php if($fars['farq10'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq10" id="FARQ1000" value="3" <?php if($fars['farq10'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq10" id="FARQ10000" value="4" <?php if($fars['farq10'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq10" id="FARQ100000" value="5" <?php if($fars['farq10'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 11 -->
                                <h5>11. Taught the lesson logically, organized and in meaningful sequence. </h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq11" id="FARQ11" value="1" <?php if($fars['farq11'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq11" id="FARQ111" value="2" <?php if($fars['farq11'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq11" id="FARQ1111" value="3" <?php if($fars['farq11'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq11" id="FARQ11111" value="4" <?php if($fars['farq11'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq11" id="FARQ111111" value="5" <?php if($fars['farq11'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 12 -->
                                <h5>12. Presented the lesson clearly (speaks in well-modulated voice and proper enunciation/pronunciation). </h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq12" id="FARQ12" value="1" <?php if($fars['farq11'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq12" id="FARQ122" value="2" <?php if($fars['farq11'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq12" id="FARQ1222" value="3" <?php if($fars['farq11'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq12" id="FARQ12222" value="4" <?php if($fars['farq11'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq12" id="FARQ122222" value="5" <?php if($fars['farq11'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 13 -->
                                <h5>13. Applied the lesson to real life scenario and/or cited applicable examples from other disciplines or areas of study.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq13" id="FARQ13" value="1" <?php if($fars['farq13'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq13" id="FARQ133" value="2" <?php if($fars['farq13'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq13" id="FARQ1333" value="3" <?php if($fars['farq13'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq13" id="FARQ13333" value="4" <?php if($fars['farq13'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq13" id="FARQ133333" value="5" <?php if($fars['farq13'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 14 -->
                                <h5>14.    Instructed the students to highlight important points and sum up the lesson.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq14" id="FARQ14" value="1" <?php if($fars['farq14'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq14" id="FARQ144" value="2" <?php if($fars['farq14'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq14" id="FARQ1444" value="3" <?php if($fars['farq14'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq14" id="FARQ14444" value="4" <?php if($fars['farq14'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq14" id="FARQ144444" value="5" <?php if($fars['farq14'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 15 -->
                                <h5>15. Recognized participation of the students throughout class discussion.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq15" id="FARQ15" value="1" <?php if($fars['farq15'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq15" id="FARQ155" value="2" <?php if($fars['farq15'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq15" id="FARQ1555" value="3" <?php if($fars['farq15'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq15" id="FARQ15555" value="4" <?php if($fars['farq15'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq15" id="FARQ155555" value="5" <?php if($fars['farq15'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 16 -->
                                <h5>16. Encouraged and provided students opportunities to speak (in appropriate language by expressing their ideas or by asking questions).</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq16" id="FARQ16" value="1" <?php if($fars['farq16'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq16" id="FARQ166" value="2" <?php if($fars['farq16'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq16" id="FARQ1666" value="3" <?php if($fars['farq16'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq16" id="FARQ16666" value="4" <?php if($fars['farq16'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq16" id="FARQ166666" value="5" <?php if($fars['farq16'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 17 -->
                                <h5>17. Encouraged students to respond to questions by providing hints, examples or rearticulating the problem.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq17" id="FARQ17" value="1" <?php if($fars['farq17'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq17" id="FARQ177" value="2" <?php if($fars['farq17'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq17" id="FARQ1777" value="3" <?php if($fars['farq17'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq17" id="FARQ17777" value="4" <?php if($fars['farq17'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq17" id="FARQ177777" value="5" <?php if($fars['farq17'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 18 -->
                                <h5>18. Used time effectively during the classes.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq18" id="FARQ18" value="1" <?php if($fars['farq18'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq18" id="FARQ188" value="2" <?php if($fars['farq18'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq18" id="FARQ1888" value="3" <?php if($fars['farq18'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq18" id="FARQ18888" value="4" <?php if($fars['farq18'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq18" id="FARQ188888" value="5" <?php if($fars['farq18'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 19 -->
                                <h5>19. Kept students focused for the entire duration of the session.</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq19" id="FARQ19" value="1" <?php if($fars['farq19'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq19" id="FARQ199" value="2" <?php if($fars['farq19'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq19" id="FARQ1999" value="3" <?php if($fars['farq19'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq19" id="FARQ19999" value="4" <?php if($fars['farq19'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq19" id="FARQ199999" value="5" <?php if($fars['farq19'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 20 -->
                                <h5>20. Incorporated relevant HCC Core Values (Fides, Caritas, Libertas)</h5>
                                <table  style="width: 100%">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="text-align: center;">
                                            <td><input class="form-check-input" type="radio" name="txtfarq20" id="FARQ20" value="1" <?php if($fars['farq20'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq20" id="FARQ200" value="2" <?php if($fars['farq20'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq20" id="FARQ2000" value="3" <?php if($fars['farq20'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq20" id="FARQ20000" value="4" <?php if($fars['farq20'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq20" id="FARQ200000" value="5" <?php if($fars['farq20'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <button class="btn btn-success" style="width: 100%;" type="submit">NEXT</button>
                                <p>Please do not close this tab until the evaluation is done. Thank you!</p>
                            </div>
                        <?= form_close(); ?>
                    </div>
                </div>                               
            </div>
        </div>
    <?php endforeach; ?>
    <!-- End of Page Content -->

    <!-- ----------- FOOTER ------------------ -->
    <?= $this->include("partials/footer"); ?>
    <!-- ----------- END OF FOOTER ------------------ -->

<?= $this->endSection(); ?>