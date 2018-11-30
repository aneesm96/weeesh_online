<?php $__env->startSection('content'); ?>

<!-- create.blade.php -->
<!-- https://appdividend.com/2017/08/20/laravel-5-5-tutorial-example/#Step_3_Create_a_model_as_well_as_migration_file_for_our_Products_table -->
    <div class="container">
      <h2>Create A List</h2><br  />


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




      <form method="post" action="<?php echo e(url('wlists')); ?>">
          <?php echo e(csrf_field()); ?>

        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name">
          </div>
        </div>

          <?php $listPrivacies = \Weeesh\ListPrivacy::pluck('name', 'id_list_privacy')->toArray() ?>

          <div class="row">
              <div class="col-md-4"></div>
              <div class="form-group col-md-4">
                  <label for="name">Privacy:</label>
                  <?php echo Form::select('id_list_privacy', $listPrivacies, null, ['class' => 'form-control']); ?>

              </div>
          </div>




        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-left:38px">Create List</button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>