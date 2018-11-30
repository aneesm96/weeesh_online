<?php $__env->startSection('content'); ?>

<!-- create.blade.php -->
<!-- https://appdividend.com/2017/08/20/laravel-5-5-tutorial-example/#Step_3_Create_a_model_as_well_as_migration_file_for_our_Products_table -->
    <div class="container">


        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn btn-group cen">
                    <?php echo app('translator')->getFromJson("Create A List"); ?>
                </div>
            </div>
        </div>


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

      <form method="post" action="<?php echo e(url('wlists')); ?>" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="name"><?php echo app('translator')->getFromJson("Name"); ?>:</label>
            <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>">
          </div>
        </div>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="date_valide_to"><?php echo app('translator')->getFromJson("Valide to"); ?>:</label>
                  <input type="date" class="form-control" name="date_valide_to"
                         value="<?php echo e(old('date_valide_to')); ?>">
              </div>
          </div>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="image"><?php echo app('translator')->getFromJson("Image"); ?>:</label>
                  <input type="file" class="form-control" name="image" value="<?php echo e(old('image')); ?>">
              </div>
          </div>


      <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="name"><?php echo app('translator')->getFromJson("Visibility"); ?>:</label>
                  <?php echo Form::select('id_list_privacy', $listPrivacies, null, ['class' => 'form-control']); ?>

              </div>
          </div>




        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-left:38px"><?php echo app('translator')->getFromJson("Insert List"); ?></button>
          </div>
        </div>
      </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>