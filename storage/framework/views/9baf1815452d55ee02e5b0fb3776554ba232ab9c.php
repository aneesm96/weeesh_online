<?php $__env->startSection('content'); ?>

<div class="container">
    <br />
    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e(\Session::get('success')); ?></p>
        </div><br />
    <?php endif; ?>
    <table class="table table-striped">
        <thead>
        <tr>

            <th>Name</th>
            <th>Privacy</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $wlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wlistKey => $wlistValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>

                <td><?php echo e($wlistValue->name); ?></td>
                <td><?php echo e($wlistValue->list_privacy()); ?></td>

                <td><a href="<?php echo e(action('WListController@edit', $wlistValue->id_list)); ?>" class="btn btn-warning">Edit</a></td>
                <td>
                    <form action="<?php echo e(action('WListController@destroy', $wlistValue->id_list)); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>