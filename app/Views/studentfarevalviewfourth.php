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
                        <?= form_open('studentfar/evaluationfifth/'.$fars['farid']); ?>
                            <div class="card-body">
                                <h5>B. CLASSROOM MANAGEMENT</h5>
                                <br>
                                <!-- 21 -->
                                <h5>1. Observed punctuality in starting the classes (starts and ends class on time).</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq21" id="FARQ21" value="1" <?php if($fars['farq21'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq21" id="FARQ211" value="2" <?php if($fars['farq21'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq21" id="FARQ2111" value="3" <?php if($fars['farq21'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq21" id="FARQ21111" value="4" <?php if($fars['farq21'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq21" id="FARQ211111" value="5" <?php if($fars['farq21'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 22 -->
                                <h5>2. Set atmosphere suitable for learning despite limitations of the environment.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq22" id="FARQ22" value="1" <?php if($fars['farq22'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq22" id="FARQ222" value="2" <?php if($fars['farq22'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq22" id="FARQ2222" value="3" <?php if($fars['farq22'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq22" id="FARQ22222" value="4" <?php if($fars['farq22'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq22" id="FARQ222222" value="5" <?php if($fars['farq22'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 23 -->
                                <h5>3 . Fostered healthy academic exchange keeping order and discipline but relaxed atmosphere.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq23" id="FARQ23" value="1" <?php if($fars['farq23'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq23" id="FARQ233" value="2" <?php if($fars['farq23'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq23" id="FARQ2333" value="3" <?php if($fars['farq23'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq23" id="FARQ23333" value="4" <?php if($fars['farq23'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq23" id="FARQ233333" value="5" <?php if($fars['farq23'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 24 -->
                                <h5>4. Helped underachievers understand the lesson with patience and understanding.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq24" id="FARQ24" value="1" <?php if($fars['farq24'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq24" id="FARQ244" value="2" <?php if($fars['farq24'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq24" id="FARQ2444" value="3" <?php if($fars['farq24'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq24" id="FARQ24444" value="4" <?php if($fars['farq24'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq24" id="FARQ244444" value="5" <?php if($fars['farq24'] == '5'){ echo'checked';}else{} ?>></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <!-- 25 -->
                                <h5>5. Evaluated results in orderly and systematic manner.</h5>
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
                                            <td><input class="form-check-input" type="radio" name="txtfarq25" id="FARQ25" value="1" <?php if($fars['farq25'] == '1'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq25" id="FARQ255" value="2" <?php if($fars['farq25'] == '2'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq25" id="FARQ2555" value="3" <?php if($fars['farq25'] == '3'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq25" id="FARQ25555" value="4" <?php if($fars['farq25'] == '4'){ echo'checked';}else{} ?>></td>
                                            <td><input class="form-check-input" type="radio" name="txtfarq25" id="FARQ255555" value="5" <?php if($fars['farq25'] == '5'){ echo'checked';}else{} ?>></td>
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