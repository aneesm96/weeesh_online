<?php $__env->startSection('content'); ?>

    <div class="container">

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div><br />
        <?php endif; ?>
        <?php if(\Session::has('success')): ?>
            <div class="alert alert-success">
                <p><?php echo e(\Session::get('success')); ?></p>
            </div><br />
        <?php endif; ?>



            <div class="row">
                <div class="col-xs-12 nomelista"><?php echo e($wlist->name); ?></div>
            </div>
            <div class="row">
                <div class="col-xs-12">di
                    <a href="<?php echo e(action('UserProfileController@show', [$userProfile->id_user_profile])); ?>">
                        <?php echo e($userProfile->name . " " . $userProfile->surname); ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 "><?php echo app('translator')->getFromJson("Valide to"); ?>: <?php echo e(date('d/m/Y', strtotime($wlist->date_valide_to))); ?></div>

            </div>


    <h2><?php echo app('translator')->getFromJson("Objects"); ?></h2>

    <?php if($wlist->list_rows->count() == 0): ?>

        <p>
            <?php echo app('translator')->getFromJson("Not yet object for this list."); ?>
        </p>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-striped responsive">
                <?php $__currentLoopData = $wlist->list_rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php
                        /*
                         * date: 30/12/17
                         * time: 11:36
                         * user: Francesco
                         *
                         * recupero l'id_user_profile dell'utente loggato, visto che al momento ogni utente
                         * ha un solo user_profile
                         *
                         * @TODO: migliorare quest'aspetto, l'utente deve poter scegliere il proprio profilo
                         */
                        $id_up  = (\Auth::user()->user_profiles)[0]['id_user_profile']
                        ?>
                            <?php if($list_row->isBooked()): ?>

                                    <td>
                                        <div class="status giallo"></div>
                                        <div style="float: left"><?php echo e($list_row->object); ?></div>
                                    </td>
                                <?php
                                /*
                                 * date: 20/01/2018
                                 * time: 19:40
                                 * user: Francesco
                                 *
                                 * recupero la riga di booking relativa all'user profile
                                 *
                                 */
                                $booking = \Weeesh\Http\Controllers\BookingController::getBooking($list_row->id_list_row)
                                ?>
                                    <td>
                                        <?php if($booking->id_user_profile = $id_up): ?>
                                                <form action="<?php echo e(action('BookingController@destroy',$booking->id_booking)); ?>"
                                                      method="post">
                                                    <?php echo e(csrf_field()); ?>

                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Undo"); ?></button>
                                                </form>
                                        <?php else: ?>
                                            <?php echo app('translator')->getFromJson("Already booked"); ?>
                                        <?php endif; ?>
                                    </td>

                            <?php else: ?>

                                    <td >
                                        <div class="status verde"></div>
                                        <div style="float: left"><?php echo e($list_row->object); ?></div>
                                    </td>
                                    <td >
                                        <form action="<?php echo e(action('BookingController@store')); ?>" method="post">
                                            <?php echo e(csrf_field()); ?>

                                            <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Book now"); ?></button>
                                            <input type="hidden" name="id_state_booking" value="1"/>
                                            <input type="hidden" name="id_list_row" value="<?php echo e($list_row->id_list_row); ?>"/>
                                            <input type="hidden" name="id_user_profile" value="<?php echo e($id_up); ?>"/>
                                        </form>
                                    </td>



                            <?php endif; ?>
                                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>