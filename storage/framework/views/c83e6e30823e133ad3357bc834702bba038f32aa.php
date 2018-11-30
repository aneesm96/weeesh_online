

<?php $__env->startSection('content'); ?>

<!-- create.blade.php -->
<!-- https://appdividend.com/2017/08/20/laravel-5-5-tutorial-example/#Step_3_Create_a_model_as_well_as_migration_file_for_our_Products_table -->
    <div class="container">

        <a href="<?php echo e(action('WListController@show', $wlist->id_list)); ?>"><b><?php echo e($wlist->name); ?></b></a>
        <br><?php echo app('translator')->getFromJson("Insert new Object in list:"); ?>

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

        <?php echo e(Form::open(array('route' => array('wlists.list_rows.store', $wlist->id_list), 'class' => 'form'))); ?>


          <?php echo e(csrf_field()); ?>

        <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="name"><?php echo app('translator')->getFromJson("Name"); ?>:</label>
                  <input type="text" class="form-control" name="object">
              </div>
          </div>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="link_web"><?php echo app('translator')->getFromJson("Link"); ?>:</label>
                  <input type="text" class="form-control" name="link_web">
              </div>
          </div>
          <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>
          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="name"><?php echo app('translator')->getFromJson("Privacy"); ?>:</label>
                  <?php echo Form::select('id_list_privacy', $listPrivacies, null, ['class' => 'form-control']); ?>

              </div>
          </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-left:38px"><?php echo app('translator')->getFromJson("Insert Object"); ?></button>
          </div>
        </div>
        <input type="hidden" name="id_list" value="<?php echo e($wlist->id_list); ?>"/>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>