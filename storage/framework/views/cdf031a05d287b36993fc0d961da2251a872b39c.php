<?php $__env->startSection('content'); ?>

<div class="container">

    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e(\Session::get('success')); ?></p>
        </div><br />
    <?php endif; ?>

<br/>
    <table class="table table-striped responsive">


        <?php $__currentLoopData = $friendships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friendshipKey => $friendshipValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <a href="<?php echo e(action('UserProfileController@show', $friendshipValue->id_friend)); ?>">
                        <?php echo e($friendshipValue->name); ?>

                        <?php echo e($friendshipValue->surname); ?>

                    </a>
                </td>
                <td>
                    <?php echo e(date('d/m/Y', strtotime($friendshipValue->date_from))); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>