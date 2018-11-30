

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2><?php echo app('translator')->getFromJson("Edit an Object in list:"); ?>
        <a href="<?php echo e(action('WListController@show', $list_row->id_list)); ?>"><b><?php echo e($list_row->wlist->name); ?></b></a>
    </h2><br  />
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

    <?php echo Form::model($list_row, array('method' => 'put',
        'route' => array('wlists.list_rows.update', $list_row->id_list, $list_row->id_list_row), 'class' => 'form')); ?>


        <?php echo e(csrf_field()); ?>

        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="object"><?php echo app('translator')->getFromJson("Name"); ?>:</label>
                <input type="text" class="form-control" name="object" value="<?php echo e($list_row->object); ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="link_web"><?php echo app('translator')->getFromJson("Link"); ?>:</label>
                <input type="text" class="form-control" name="link_web" value="<?php echo e($list_row->link_web); ?>">
            </div>
        </div>


        <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name"><?php echo app('translator')->getFromJson("Privacy"); ?>:</label>
                <?php echo Form::select('id_list_privacy',
                    $listPrivacies, $list_row->id_list_privacy, ['class' => 'form-control']); ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px"><?php echo app('translator')->getFromJson("Update Object"); ?></button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>