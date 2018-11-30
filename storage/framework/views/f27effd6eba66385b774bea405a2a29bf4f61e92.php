

<?php $__env->startSection('content'); ?>

<div class="container">
    <br />
    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e(\Session::get('success')); ?></p>
        </div><br />
    <?php endif; ?>



    <div class="row">
        <div class="col-md-12 text-center">
            <div class="btn btn-group cen">
                <a href="wlists/create" class="btn btn-primary">
                    <i class="fa fa-plus-square"></i> <?php echo app('translator')->getFromJson("New List"); ?>
                </a>


            </div>
        </div>
    </div>


    <table class="table table-striped responsive">

        <?php $__currentLoopData = $wlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wlistKey => $wlistValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>

                <td>
                    <a href="<?php echo e(action('WListController@show', $wlistValue->id_list)); ?>"><?php echo e($wlistValue->name); ?></a>
                </td>
                <td><?php echo e($wlistValue->list_privacy()); ?></td>


                <td>




                                <form action="<?php echo e(action('WListController@destroy', $wlistValue->id_list)); ?>"
                                      method="post" class="delete">
                                    <div class="btn btn-group">
                                    <a href="<?php echo e(URL::route('wlists.list_rows.create', $wlistValue->id_list)); ?>"
                                       class='btn btn-primary' title="<?php echo app('translator')->getFromJson("Inserisci un nuovo oggetto"); ?>">
                                        <i class="fa fa-plus-square"></i>
                                    </a>


                                    <a href="<?php echo e(action('WListController@edit', $wlistValue->id_list)); ?>"
                                       class="btn btn-warning" title="<?php echo app('translator')->getFromJson("Modifica la lista"); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <?php if( count( $wlistValue->list_rows) == 0): ?>
                                    <?php echo e(csrf_field()); ?>

                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="btn btn-danger" type="submit" title="<?php echo app('translator')->getFromJson("Cancella la lista"); ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                    </div>
                                </form>




            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>