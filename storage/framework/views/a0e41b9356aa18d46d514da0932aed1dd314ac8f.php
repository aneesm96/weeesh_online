

<?php $__env->startSection('content'); ?>

<div class="container">



    <br />
    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e(\Session::get('success')); ?></p>
        </div><br />
    <?php endif; ?>


    <table class="table table-striped responsive">

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
        <?php $__currentLoopData = $user_profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
            <?php if($user_profile->id_user_profile != $id_up ): ?>
                    <td>
                        <a href="<?php echo e(url('/user_profiles').'/'.$user_profile->id_user_profile); ?>">
                        <?php echo e($user_profile->name); ?> <?php echo e($user_profile->surname); ?>


                    </td>

                        <?php if(  $user_profile->isFriend($id_up) ): ?>
                        <td colspan="2">

                            <a href="<?php echo e(url('/user_profiles').'/'.$user_profile->id_user_profile); ?>">
                                <?php echo app('translator')->getFromJson("View profile"); ?>
                            </a>
                        </td>

                        <?php elseif( $user_profile->fsRequestSend($id_up)): ?>
                            <?php //se l'ho ricevuta posso accettare/rifiutare, altrimenti cancellare/waiting ?>

                            <?php $fsr = \Weeesh\Http\Controllers\FsRequestController::get($id_up, $user_profile->id_user_profile); ?>

                            <?php if($fsr[0]->id_user_profile_by == $id_up and $fsr[0]->id_fs_request_state < 2 ): ?>
                                <td colspan="2">
                                    <form action="<?php echo e(action('FsRequestController@update',$fsr[0]->id_fs_request)); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Undo"); ?></button>
                                        <input type="hidden" name="id_fs_request_state" value="2"/>
                                    </form>
                                </td>

                            <?php elseif($fsr[0]->id_fs_request_state < 2): ?>
                                <td>
                                    <form action="<?php echo e(action('FsRequestController@update',$fsr[0]->id_fs_request)); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Accept"); ?></button>
                                        <input type="hidden" name="id_fs_request_state" value="1"/>

                                    </form>
                                </td>
                                <td>
                                    <form action="<?php echo e(action('FsRequestController@update',$fsr[0]->id_fs_request)); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Deny"); ?></button>
                                        <input type="hidden" name="id_fs_request_state" value="2">

                                    </form>
                                </td>
                            <?php elseif($fsr[0]->id_fs_request_state = 2 && $fsr[0]->id_user_profile_by != $id_up): ?>
                                    <td colspan="2">
                                    <?php echo app('translator')->getFromJson("Not accepted!"); ?>
                                    </td>
                            <?php endif; ?>

                    <?php else: ?>
                            <td colspan="2">
                            <form action="<?php echo e(action('FsRequestController@store')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>


                                <button class="btn btn-primary" type="submit"><?php echo app('translator')->getFromJson("Send Request"); ?></button>
                                <input type="hidden" name="id_user_profile_by" value="<?php echo e($id_up); ?>"/>
                                <input type="hidden" name="id_user_profile_to" value="<?php echo e($user_profile->id_user_profile); ?>"/>
                            </form>
                            </td>
                        <?php endif; ?>
            <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>