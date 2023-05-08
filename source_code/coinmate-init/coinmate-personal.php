<div class="d-flex align-items-center gap-5">
                            <div class="flex-1">
                                <img src="<?php echo ROOT_URL; ?>/dynamic/pfp/<?php echo $userDetails['pfp']; ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="flex-2">
                                <h3><?php echo $userDetails['username']; ?></h3>
                            </div>
                        </div>
                        <!-- personal information -->
                        <div class="personal-information p-4">
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td><?php echo $userDetails['name'] ? $userDetails['name'] : 'empty'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sex</td>
                                        <td class="text-capitalize"><?php echo $userDetails['gender'] ? $userDetails['gender'] : 'empty'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td><?php echo $userDetails['country'] ? $countries[$userDetails['country']] : 'empty'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td><?php echo $userDetails['city'] ? $userDetails['city'] : 'empty'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Zipcode</td>
                                        <td><?php echo $userDetails['zipcode'] ? $userDetails['zipcode'] : 'empty'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Age</td>
                                        <td><?php echo $userDetails['age'] ? $userDetails['age'] : 'empty'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>