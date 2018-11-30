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


    <a href="<?php echo e(URL::route('wlists.index')); ?>"><?php echo app('translator')->getFromJson("My Lists"); ?></a> ><h1> <?php echo e($wlist->name); ?></h1>

    <p>
        <?php echo app('translator')->getFromJson("Created on"); ?>: <?php echo e(date('F d, Y', strtotime($wlist->created_at))); ?> <br />
        <?php echo app('translator')->getFromJson("Last modified"); ?>: <?php echo e(date('F d, Y', strtotime($wlist->updated_at))); ?><br />

    </p>

    <h2><?php echo app('translator')->getFromJson("Objects"); ?></h2>

    <p>
        <a href="<?php echo e(URL::route('wlists.list_rows.create', $wlist->id_list)); ?>" class='btn btn-primary'><?php echo app('translator')->getFromJson("Add an object"); ?></a>
    </p>

    <?php if($wlist->list_rows->count() == 0): ?>

        <p>
            <?php echo app('translator')->getFromJson("Not yet object for this list."); ?>
            <a href="<?php echo e(URL::route('wlists.list_rows.create', $wlist->id_list)); ?>"><?php echo app('translator')->getFromJson("Add an object"); ?></a>.
        </p>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-striped responsive">
                <?php $__currentLoopData = $wlist->list_rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

                        <td>
                            <?php if($list_row->isBooked()): ?>
                                    <?php //TODO: verificare x gli oggetti gia prenotati le azioni da intraprendere?>
                                    <?php echo e($list_row->object); ?>


                            <?php else: ?>
                                <a href="<?php echo e(URL::route('wlists.list_rows.edit',  [$wlist->id_list, $list_row->id_list_row])); ?>">
                                    <?php echo e($list_row->object); ?>

                                </a>


                            <?php endif; ?>
                        </td>
                        <!--
                        <td>
                            <a href="<?php echo e(URL::route('wlists.list_rows.edit',  [$wlist->id_list, $list_row->id_list_row])); ?>"><?php echo app('translator')->getFromJson("Edit"); ?></a>
                        </td>
                        -->
                        <td>
                            <?php
                                /**
                                 *
                                 * TODO: se l'oggetto è stato prenotato, non posso cancellare
                                 * x cancellare: mando una mail a chi ha prenotato,chiedendo se faccio ancora
                                 * in tempo a cancellare
                                 * x modificare: mando una mail a chi ha prenotato,chiedendo se faccio ancora
                                 * in tempo a modificare
                                 *
                                 * resto in attesa di risposta
                                 */
                               ?>
                            <?php if($list_row->isBooked()): ?>

                                <?php echo app('translator')->getFromJson("Already Booked"); ?>

                            <?php else: ?>
                            <form action="<?php echo e(URL::route('wlists.list_rows.destroy', [$wlist->id_list, $list_row->id_list_row])); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <input name="_method" type="hidden" value="DELETE">
                                <button class="btn btn-danger" type="submit"><?php echo app('translator')->getFromJson("Delete"); ?></button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>