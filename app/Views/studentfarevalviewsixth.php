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
                            <h4><strong>II. PROFESSIONALISM</strong></h4>
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
                        <?= form_open('studentfar/evaluationseventh/'.$fars['farid']); ?>
                            <div class="card-body">
                                <!-- <h5>B. CLASSROOM MANAGEMENT</h5>
                                <br> -->
                                <!-- 26 -->
                                <h5>1. Attended his/her classes regularly (religiously).</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq26" id="FARQ26" value="1" <?php if($fars['farq26'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq26" id="FARQ266" value="2" <?php if($fars['farq26'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq26" id="FARQ2666" value="3" <?php if($fars['farq26'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq26" id="FARQ26666" value="4" <?php if($fars['farq26'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq26" id="FARQ266666" value="5" <?php if($fars['farq26'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 27 -->
                                <h5>2. Observed punctuality</h5>
                                <p>a. in attending the class (starts and ends class on time)</p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq27" id="FARQ27" value="1" <?php if($fars['farq27'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq27" id="FARQ277" value="2" <?php if($fars['farq27'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq27" id="FARQ2777" value="3" <?php if($fars['farq27'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq27" id="FARQ27777" value="4" <?php if($fars['farq27'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq27" id="FARQ277777" value="5" <?php if($fars['farq27'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 28 -->
                                <!-- <h5>2. Observed punctuality</h5> -->
                                <p>b. in attending school functions (meetings, in-service trainings, and other school activities)</p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq28" id="FARQ28" value="1" <?php if($fars['farq28'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq28" id="FARQ288" value="2" <?php if($fars['farq28'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq28" id="FARQ2888" value="3" <?php if($fars['farq28'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq28" id="FARQ28888" value="4" <?php if($fars['farq28'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq28" id="FARQ288888" value="5" <?php if($fars['farq28'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 29 -->
                                <h5>3. Submitted reports and other requirements on time</h5>
                                <p>a. Syllabus</p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq29" id="FARQ29" value="1" <?php if($fars['farq29'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq29" id="FARQ299" value="2" <?php if($fars['farq29'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq29" id="FARQ2999" value="3" <?php if($fars['farq29'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq29" id="FARQ29999" value="4" <?php if($fars['farq29'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq29" id="FARQ299999" value="5" <?php if($fars['farq29'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 30 -->
                                <!-- <h5>3. Submitted reports and other requirements on time</h5> -->
                                <p>b. Modules / Test Manuscripts</p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq30" id="FARQ30" value="1" <?php if($fars['farq30'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq30" id="FARQ300" value="2" <?php if($fars['farq30'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq30" id="FARQ3000" value="3" <?php if($fars['farq30'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq30" id="FARQ30000" value="4" <?php if($fars['farq30'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq30" id="FARQ300000" value="5" <?php if($fars['farq30'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 31 -->
                                <!-- <h5>3. Submitted reports and other requirements on time</h5> -->
                                <p>c. Grades</p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq31" id="FARQ31" value="1" <?php if($fars['farq31'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq31" id="FARQ311" value="2" <?php if($fars['farq31'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq31" id="FARQ3111" value="3" <?php if($fars['farq31'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq31" id="FARQ31111" value="4" <?php if($fars['farq31'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq31" id="FARQ311111" value="5" <?php if($fars['farq31'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 32 -->
                                <h5>4. Observed and followed school policies</h5>
                                <p>a.   in proper attire and grooming</p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq32" id="FARQ32" value="1" <?php if($fars['farq32'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq32" id="FARQ322" value="2" <?php if($fars['farq32'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq32" id="FARQ3222" value="3" <?php if($fars['farq32'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq32" id="FARQ32222" value="4" <?php if($fars['farq32'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq32" id="FARQ322222" value="5" <?php if($fars['farq32'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 33 -->
                                <!-- <h5>3. Submitted reports and other requirements on time</h5> -->
                                <p>b. in proper channeling  and good working relationship with colleagues, administrators and other school personnel.</p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq33" id="FARQ33" value="1" <?php if($fars['farq33'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq33" id="FARQ333" value="2" <?php if($fars['farq33'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq33" id="FARQ3333" value="3" <?php if($fars['farq33'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq33" id="FARQ33333" value="4" <?php if($fars['farq33'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq33" id="FARQ333333" value="5" <?php if($fars['farq33'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 34 -->
                                <!-- <h5>3. Submitted reports and other requirements on time</h5> -->
                                <p>c. in dealing with all the members of HCC Community with respect. </p>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq34" id="FARQ34" value="1" <?php if($fars['farq34'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq34" id="FARQ344" value="2" <?php if($fars['farq34'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq34" id="FARQ3444" value="3" <?php if($fars['farq34'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq34" id="FARQ34444" value="4" <?php if($fars['farq34'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq34" id="FARQ344444" value="5" <?php if($fars['farq34'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 35 -->
                                <h5>5. Showed leadership in department/organization activities.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq35" id="FARQ35" value="1" <?php if($fars['farq35'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq35" id="FARQ355" value="2" <?php if($fars['farq35'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq35" id="FARQ3555" value="3" <?php if($fars['farq35'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq35" id="FARQ35555" value="4" <?php if($fars['farq35'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq35" id="FARQ355555" value="5" <?php if($fars['farq35'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 36 -->
                                <h5>6. Assisted in organizing and performing school activities.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq36" id="FARQ36" value="1" <?php if($fars['farq36'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq36" id="FARQ366" value="2" <?php if($fars['farq36'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq36" id="FARQ3666" value="3" <?php if($fars['farq36'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq36" id="FARQ36666" value="4" <?php if($fars['farq36'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq36" id="FARQ366666" value="5" <?php if($fars['farq36'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 37 -->
                                <h5>7. Shared his/her expertise and time as needed. </h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq37" id="FARQ37" value="1" <?php if($fars['farq37'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq37" id="FARQ377" value="2" <?php if($fars['farq37'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq37" id="FARQ3777" value="3" <?php if($fars['farq37'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq37" id="FARQ37777" value="4" <?php if($fars['farq37'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq37" id="FARQ377777" value="5" <?php if($fars['farq37'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 38 -->
                                <h5>8. Displayed desire to work longer than the official hours.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq38" id="FARQ38" value="1" <?php if($fars['farq38'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq38" id="FARQ388" value="2" <?php if($fars['farq38'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq38" id="FARQ3888" value="3" <?php if($fars['farq38'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq38" id="FARQ38888" value="4" <?php if($fars['farq38'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq38" id="FARQ388888" value="5" <?php if($fars['farq38'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 39 -->
                                <h5>9. Demonstrated openness to innovations, constructive criticism, and feedback.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq39" id="FARQ39" value="1" <?php if($fars['farq39'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq39" id="FARQ399" value="2" <?php if($fars['farq39'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq39" id="FARQ3999" value="3" <?php if($fars['farq39'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq39" id="FARQ39999" value="4" <?php if($fars['farq39'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq39" id="FARQ399999" value="5" <?php if($fars['farq39'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 40 -->
                                <h5>10. Interacted with parents and students with respect.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq40" id="FARQ40" value="1" <?php if($fars['farq40'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq40" id="FARQ400" value="2" <?php if($fars['farq40'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq40" id="FARQ4000" value="3" <?php if($fars['farq40'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq40" id="FARQ40000" value="4" <?php if($fars['farq40'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq40" id="FARQ400000" value="5" <?php if($fars['farq40'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 41 -->
                                <h5>11. Practiced HCC’s vison, mission and core values.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq41" id="FARQ41" value="1" <?php if($fars['farq41'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq41" id="FARQ411" value="2" <?php if($fars['farq41'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq41" id="FARQ4111" value="3" <?php if($fars['farq41'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq41" id="FARQ41111" value="4" <?php if($fars['farq41'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq41" id="FARQ411111" value="5" <?php if($fars['farq41'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 42 -->
                                <h5>12. Manifested integrity and honesty at all times. </h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq42" id="FARQ42" value="1" <?php if($fars['farq42'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq42" id="FARQ422" value="2" <?php if($fars['farq42'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq42" id="FARQ4222" value="3" <?php if($fars['farq42'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq42" id="FARQ42222" value="4" <?php if($fars['farq42'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq42" id="FARQ422222" value="5" <?php if($fars['farq42'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- Comment -->
                                <h5>Comments and suggestions:</h5>
                                <textarea class="form-control" name="txtfarcomment"><?= $fars['farcomment']; ?></textarea>
                                <br>
                                <button class="btn btn-success" style="width: 100%;" type="submit">SUBMIT</button>
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