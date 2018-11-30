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

   <h3> <?php echo e($userProfile->name . " " . $userProfile->surname); ?></h3>

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
    <?php if($userProfile->isFriend($id_up)): ?>


            <?php if($userProfile->wlists->count() == 0): ?>

                <p>
                    <?php echo app('translator')->getFromJson("Not yet list"); ?>
                </p>

            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-striped responsive">
                        <?php $__currentLoopData = $userProfile->wlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <td>
                                    <a href="<?php echo e(URL::route('user_profiles.wlists.friend_show', [$userProfile->id_user_profile, $wlist->id_list])); ?>"><?php echo e($wlist->name); ?></a>
                                </td>
                                <td>
                                   scadenza:
                                    <?php echo e(date('d/m/Y', strtotime($wlist->date_valide_to))); ?>


                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            <?php endif; ?>

    </div>
    <?php else: ?>

        <?php echo app('translator')->getFromJson("You are not allowed"); ?>
        <br />
        <?php echo app('translator')->getFromJson("add friend"); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>