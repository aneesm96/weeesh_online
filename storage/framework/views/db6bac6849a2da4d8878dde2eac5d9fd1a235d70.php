

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2><?php echo app('translator')->getFromJson("Edit A List"); ?></h2><br  />
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
    <form method="post" action="<?php echo e(action('WListController@update', $id_list)); ?>">
        <?php echo e(csrf_field()); ?>

        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name"><?php echo app('translator')->getFromJson("Name"); ?>:</label>
                <input type="text" class="form-control" name="name" value="<?php echo e($wlist->name); ?>">
            </div>
        </div>

        <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name"><?php echo app('translator')->getFromJson("Privacy"); ?>:</label>
                <?php echo Form::select('id_list_privacy',
                    $listPrivacies, $wlist->id_list_privacy, ['class' => 'form-control']); ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px"><?php echo app('translator')->getFromJson("Update List"); ?></button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>